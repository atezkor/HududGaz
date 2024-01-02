<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Organization;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;


class RecommendationService extends CrudService {
    use FileUploadManager, StorageManager;

    private string $path = 'public/recommendations';
    private string $folder;

    private PDF $pdf;

    public function __construct(Recommendation $model, PDF $pdf) {
        $this->model = $model;
        $this->pdf = $pdf;
        $this->folder = 'recommendations';
    }

    /**
     * @param array $data
     */
    public function create($data) {
        /* @var Proposition $proposition */

        $proposition = Proposition::query()->find($data['proposition_id']);
        $data['organization_id'] = $proposition->organization_id;
        $data['applicant_id'] = $proposition->applicant->id;

        try {
            DB::beginTransaction();

            parent::create($data);
            // Update proposition
            $proposition->update(['status' => Proposition::ACCEPTED]);
            DB::commit();
        } catch (QueryException $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    public function show(Recommendation $recommendation): Response {
        $proposition = $recommendation->proposition;
        $organ = $recommendation->organ;

        $data = [
            'model' => $recommendation,
            'proposition' => $proposition,
            'organ' => $organ,
            'applicant' => $recommendation->applicant,
            'district' => $organ->district->name,
            'organization' => Organization::Data()
        ];

        if ($recommendation->type == Recommendation::ACCEPT) {
            $equipments = $this->getEquipments($recommendation->equipments);

            $data['equipments'] = $equipments;
            $data['build_type'] = $proposition->buildType();
            $data['activity'] = $proposition->activity;
        }

        view()->share($data);
        $this->pdf->loadView('organ.pdf.' . $recommendation->type);
        return $this->pdf->stream(time() . '.pdf');
    }

    public function upload(UploadedFile $pdf, Recommendation $recommendation) {
        if ($recommendation->pdf) {
            $this->deleteFile($this->folder, $recommendation->pdf);
        }

        $recommendation->setAttribute('status', Recommendation::PRESENTED);
        $recommendation->setAttribute('pdf', $this->store($pdf, $this->folder));

        $recommendation->update();
        $recommendation->proposition->update(['status' => Proposition::PRESENTED]);
    }

    public function update($data, $model) {
        $data['status'] = Recommendation::CREATED;
        parent::update($data, $model);
    }

    /**
     * This function allows the user to see the file
     */
    public function review(Recommendation $recommendation): void {
        $proposition = $recommendation->proposition;
        if ($proposition->status == Proposition::PRESENTED) {
            $proposition->update(['status' => Proposition::TECHNIC_CHECKED]);
        }
    }

    /**
     * This function for back recommendation to District
     */
    public function back(Recommendation $recommendation, string $comment) {
        try {
            DB::beginTransaction();

            $recommendation->setAttribute('comment', $comment);
            $recommendation->setAttribute('status', Recommendation::REJECTED);
            $recommendation->update();

            $recommendation->proposition->update(['status' => Proposition::REC_REJECTED]);

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function view(Recommendation $recommendation): string {
        $this->review($recommendation);
        return $this->retrieve($this->path, $recommendation->pdf);
    }

    public function getEquipments($equipmentList) {
        $equipments = json_decode($equipmentList);
        if (!$equipments)
            return [];

        foreach ($equipments as $key => $equipment) {
            $equipment->equipment = $this->equipment($equipment->equipment);
            if (!$equipment->equipment) {
                unset($equipments[$key]);
                continue;
            }
            $equipment->type = $this->equipType($equipment->type);
        }

        return $equipments;
    }

    private function equipment(int $id, $meter = false): string {
        return EquipmentType::query()->where('static', $meter)->find($id)->name ?? '';
    }

    private function equipType(int $id): string {
        return Equipment::query()->find($id)->type ?? '';
    }
}
