<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use App\Models\Montage;
use App\Models\TechCondition;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;


class MontageService extends CrudService {
    use FileUploadManager, StorageManager;

    public function __construct(Montage $model) {
        $this->model = $model;
        $this->folder = 'montages';
    }

    public function create($data): string {
        $condition = TechCondition::query()
            ->where('qrcode', $data)
            ->whereHas('proposition', function(Builder $query) {
                $query->where('status', 14);
            })->first();

        if (!$condition)
            return __('global.msg.not_found');

        $proposition = $condition->getAttribute('proposition');
        $applicant = $proposition->applicant;
        $data = [
            'proposition_id' => $proposition->id,
            'tech_condition_id' => $condition->getAttribute('id'),
            'project_id' => $condition->project->id,
            'applicant' => $applicant->name,
            'mounter_id' => auth()->user()->organ ?? 0,
            'organ' => $proposition->organ
        ];
        $montage = new Montage($data);
        $montage->save();

        $proposition->update(['status' => 15]);
        $applicant->update(['status' => 15]);

        return __('global.messages.crt');
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

    private function propStatus(Montage $montage, $status = 14) {
        $proposition = $montage->proposition;
        $proposition->update(['status' => $montage->status + $status]);
        $proposition->applicant->update(['status' => $montage->status + $status]);
    }
}
