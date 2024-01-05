<?php

namespace App\Services;

use App\Models\Montage;
use App\Models\Proposition;
use App\Models\TechCondition;
use App\Models\User;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Generator;


class MontageService extends CrudService {
    use FileUploadManager, StorageManager;

    private string $folder;

    private Generator $qrcode;

    public function __construct(Montage $model, Generator $generator) {
        $this->model = $model;
        $this->folder = 'montages';

        $this->qrcode = $generator;
    }

    public function create($data): void {
        /**
         * @var User $user
         * @var TechCondition $condition
         */

        $user = auth()->user();

        $condition = TechCondition::query()
            ->where('qrcode', $data)
            ->whereHas('proposition', function(Builder $query) {
                $query->where('status', Proposition::PROJECT_FINISHED);
            })->firstOrFail();

        $proposition = $condition->proposition;
        $data = [
            'proposition_id' => $condition->proposition_id,
            'tech_condition_id' => $condition->id,
            'project_id' => $condition->project->id,
            'mounter_id' => $user->organization_id,
            'applicant_id' => $condition->applicant_id,
            'organ_id' => $proposition->organization_id
        ];

        try {
            DB::beginTransaction();

            $proposition->update(['status' => Proposition::MONTAGE_CREATED]);

            $montage = new Montage($data);
            $montage->save();

            DB::commit();
        } catch (QueryException $ex) {
            DB::rollBack();

            throw $ex;
        }
    }

    public function view(Montage $montage, $show = false): string {
        if ($montage->status == Montage::ACCEPTED && $show) {
            $montage->update(['status' => Montage::REVIEWED]);
            $this->propStatus($montage);
        }

        return $this->retrieve($this->folder, $montage->pdf);
    }

    public function updatePart(array $data, Montage $model) {
        $model->proposition->recommendation->update(['pipe_two' => $data]);
    }

    /**
     * @throws Exception
     */
    public function finish(Montage $montage, $pdf) {
        $old = $this->model->pdf;

        try {
            DB::beginTransaction();

            $montage->update([
                'status' => Montage::ACCEPTED,
                'pdf' => $this->store($pdf, $this->folder)
            ]);

            $this->propStatus($montage);

            $this->deleteFile($this->folder, $old);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * @throws Exception
     */
    public function accept(Montage $montage, UploadedFile $pdf) {
        try {
            DB::beginTransaction();
            $old = $montage->pdf;
            $this->update([
                'status' => Montage::COMPLETED,
                'pdf' => $this->store($pdf, $this->folder)
            ],
                $montage
            );
            $this->propStatus($montage);
            $this->deleteFile($this->folder, $old);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * @throws Exception
     */
    public function cancel(Montage $montage, string $reason) {
        try {
            DB::beginTransaction();

            $this->update(['status' => Montage::CANCELLED, 'comment' => $reason], $montage);
            $this->propStatus($montage);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    public function delete($model) {
        $this->propStatus($model, -$model->status);
        parent::delete($model);
    }

    public function qrcode() {
        return $this->qrcode->size(400)->generate(json_encode([
            'token' => csrf_token(),
            'url' => route('mounter.project.open')
        ]));
    }

    private function propStatus(Montage $montage, $status = Proposition::PROJECT_FINISHED) {
        $proposition = $montage->proposition;
        $proposition->update(['status' => $montage->status + $status]);
    }
}
