<?php

namespace App\Services;

use App\Models\Montage;
use App\Models\Proposition;
use App\Models\TechCondition;
use App\Models\User;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public function updatePart($data, $model) {
        $model->proposition->recommendation->update(['pipe2' => $data]);
    }

    public function upload($data, Montage $montage) {
        if ($this->model->file)
            $this->deleteFile($this->folder, $this->model->file);

        $montage->update([
            'status' => 2,
            'file' => $this->store($data['file'], $this->folder)
        ]);

        $this->propStatus($montage);
    }

    public function show(Montage $montage, $show = false): string {
        if ($montage->status == 2 && $show) {
            $montage->update(['status' => 3]);
            $this->propStatus($montage);
        }

        return Storage::url("$this->folder/" . $montage->file);
    }

    public function action($file, Montage $montage) {
        $this->deleteFile($this->folder, $montage->file);
        $this->update(
            ['status' => 5, 'file' => $this->store($file, $this->folder)],
            $montage
        );
        $this->propStatus($montage);
    }

    public function cancel(string $comment, Montage $montage) {
        $this->update(['status' => 4, 'comment' => $comment], $montage);
        $this->propStatus($montage);
    }

    public function delete($model) {
        $this->propStatus($model, -$model->status);
        parent::delete($model);
    }

    public function qrcode() {
        return $this->qrcode->size(500)->generate(json_encode([
            'token' => csrf_token(),
            'url' => route('mounter.project.open')
        ]));
    }

    private function propStatus(Montage $montage, $status = 14) {
        $proposition = $montage->proposition;
        $proposition->update(['status' => $montage->status + $status]);
    }
}
