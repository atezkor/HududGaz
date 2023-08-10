<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Organization;
use App\Models\Project;
use App\Models\TechCondition;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;


class ProjectService extends CrudService {
    use FileUploadManager, StorageManager;

    private string $path = '/storage/projects/';

    public function __construct(Project $model) {
        $this->model = $model;
        $this->folder = 'projects';
    }

    public function create($data): string {
        $condition = TechCondition::query()->where('qrcode', $data)
            ->whereHas('proposition', function(Builder $query) {
                return $query->where('status', 8);
            })->first();

        if (!$condition)
            return __('global.msg.not_found');

        $proposition = $condition->proposition;
        $applicant = $proposition->applicant;
        $data = [
            'proposition_id' => $proposition->id,
            'tech_condition_id' => $condition->id,
            'organ' => $proposition->organ,
            'designer_id' => auth()->user()->organ ?? 0
        ];

        $project = new Project($data);
        $project->save();

        $proposition->update(['status' => 10]);
        $applicant->update(['status' => 10]);
        return __('global.messages.crt');
    }

    public function upload($file, Project $project) {
        if ($project->file)
            $this->deleteFile($this->folder, $project->file);

        $data = [
            'file' => $this->storeFile($file['file'], $this->folder),
            'status' => 2
        ];

        $project->fill($data);
        $this->update($data, $project);
        $this->propStatus($project);
    }

    public function generateLetter(Project $project): array {
        $proposition = $project->proposition;
        $recommendation = $proposition->recommendation;
        return [
            'proposition' => $proposition,
            'applicant' => $proposition->applicant,
            'recommendation' => $proposition->recommendation,
            'build_type' => $proposition->buildType(),
            'condition' => $proposition->tech_condition,
            'organization' => Organization::Data()->shareholder_name,
            'gas_meters' => $recommendation->GasMeters(),
            'equipments' => $recommendation->getEquipments()
        ];
    }

    public function show(Project $project, $show = null): string {
        if ($project->status == 2 && $show) {
            $project->update(['status' => 3]);
            $this->propStatus($project);
        }

        return $this->path . $project->file;
    }

    public function confirm($file, Project $project) {
        $this->deleteFile($this->folder, $project->file);
        $this->update([
            'status' => 5,
            'file' => $this->storeFile($file, $this->folder)
        ], $project);

        $this->propStatus($project);
    }

    public function cancel(string $comment, Project $project) {
        $this->update(['status' => 4, 'comment' => $comment], $project);
        $this->propStatus($project);
    }

    public function delete($model) {
        $this->propStatus($model, 7);
        parent::delete($model);
    }

    private function propStatus(Project $project, $status = 9) {
        $proposition = $project->proposition;
        $proposition->update(['status' => $project->status + $status]);
        $proposition->applicant->update(['status' => $project->status + $status]);
    }
}
