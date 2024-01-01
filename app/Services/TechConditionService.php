<?php

namespace App\Services;

use App\Models\CancelledProposition;
use App\Models\Organization;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Models\TechCondition;
use App\Utilities\CodeGenerator;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;
use Barryvdh\DomPDF\PDF;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Generator;


class TechConditionService extends CrudService {
    use FileUploadManager, StorageManager, CodeGenerator;

    private PDF $pdf;
    private Generator $qrcode;
    private string $path = 'storage/tech_conditions/';
    private string $folder;

    public function __construct(TechCondition $model, PDF $pdf, Generator $qrcode) {
        $this->folder = 'tech_conditions';
        $this->model = $model;
        $this->pdf = $pdf;
        $this->qrcode = $qrcode;
    }

    /**
     * @throws Exception
     */
    public function create($data, Recommendation $model = null) {
        $proposition = $model->proposition;
        $techCondition = TechCondition::query()
            ->where('proposition_id', $proposition->id)
            ->first();
        if ($techCondition)
            return;

        // Create tech-condition
        $techCondition = new TechCondition([
            'proposition_id' => $proposition->id,
            'qrcode' => $this->qrcodeGenerate(4)
        ]);

        try {
            DB::beginTransaction();

            // Update proposition status
            $proposition->update(['status' => Proposition::TC_CREATED]);

            // Update recommendation status
            $model->update([
                'status' => Recommendation::COMPLETED,
                'description' => $data['description']
            ]);

            // Create pdf file
            $filename = $this->createPDF($techCondition, $model, $proposition, $data['data']);

            // Technic condition
            $techCondition->pdf = $filename;
            $techCondition->save();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * This function to showing the tech-condition
     */
    public function get(TechCondition $condition): string {
        return Storage::url('tech_conditions/' . $condition->pdf);
    }

    /**
     * @param array $data
     * @param TechCondition $model
     */
    public function update(array $data, $model) {
        $old = $model->pdf;
        $proposition = $model->proposition;

        // Create new pdf file for model
        $filename = $this->createPDF($model, $proposition->recommendation, $proposition, $data['data']);

        // Delete old pdf file
        $this->deleteFile($this->path, $old);

        // Update model attributes
        parent::update(['pdf' => $filename], $model);
    }

    public function upload($request, TechCondition $condition) {
        $proposition = $condition->proposition;
        $recommendation = $proposition->recommendation;

        $filename = $this->store($request->file('pdf'), $this->folder);
        $condition->fill([
            'pdf' => $filename,
            'status' => Recommendation::PRESENTED
        ]);

        // Migrate data to reservation table
        if ($recommendation->type == Recommendation::REJECT) {
            $this->cancel($proposition, $recommendation, $condition);
            return;
        }

        $this->deleteFile($this->path, $condition->pdf);
        $condition->update();
        $proposition->update(['status' => Proposition::PROJECT_C]);
    }

    private function createPDF(TechCondition $techCondition, Recommendation $recommendation, Proposition $proposition, string $text): string {
        $organ = $recommendation->organ;
        $data = [
            'id' => $techCondition->id,
            'recommendation' => $recommendation,
            'proposition' => $proposition,
            'organ' => $organ,
            'district' => $organ->district->name,
            'organization' => Organization::Data()
        ];

        $data['reference'] = $text;
        if ($recommendation->type == Recommendation::ACCEPT) {
            $equipments = []; // $recommendation->getEquipments();

            $data['equipments'] = $equipments;
            $data['qrcode'] = $this->qrcode->generate($techCondition->qrcode);
        }

        $filename = time() . '.pdf';
        view()->share($data);
        $this->pdf->loadView("technic.pdf.$recommendation->type");
        $this->pdf->save($this->path . $filename);

        return $filename;
    }

    private function cancel(Proposition $proposition, Recommendation $recommendation, TechCondition $condition) {
        $cancelled = new CancelledProposition();
        $cancelled->fill([
            'number' => $proposition->number,
            'applicant_id' => $recommendation->applicant_id,
            'organization_id' => $proposition->organization_id,
            'proposition' => 'p' . $proposition->pdf,
            'recommendation' => 'r' . $recommendation->pdf,
            'condition' => 'c' . $condition->pdf,
            'reason' => $recommendation->description
        ]);

        $this->move('tech_conditions/', $condition->pdf, 'c');
        $this->move('recommendations/', $recommendation->pdf, 'r');
        $this->move('propositions/', $proposition->pdf, 'p');

        // Cascade on delete [Recommendation and TechCondition]
        $this->delete($proposition);

        $cancelled->save();
    }
}
