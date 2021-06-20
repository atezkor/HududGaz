<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\TechCondition;


class ProjectService extends CrudService {
    private string $path = '/storage/projects/';

    public function __construct(Project $model) {
        $this->model = $model;
        $this->folder = 'projects';
    }

    public function create($data) {
        $condition = TechCondition::query()->where('qrcode', $data)
            ->whereHas('proposition', function(Builder $query) {
                return $query->where('status', 8);
            })->first();
        if (!$condition)
            return;

        $proposition = $condition->getAttribute('proposition');
        $applicant = $proposition->applicant;
        $data = [
            'proposition_id' => $proposition->id,
            'condition' => $condition->getAttribute('id'),
            'applicant' => $applicant->name,
            'organ' => $proposition->organ,
            'designer' => auth()->user()->organ ?? 0
        ];
        $project = new Project($data);
        $project->save();

        $proposition->update(['status' => 10]);
        $applicant->update(['status' => 10]);
    }

    public function upload(Request $request, Project $project) {
        if ($project->file)
            $this->deleteFile($project->file);
        $data = [
            'file' => $this->uploadFile($request->file('file')),
            'status' => 2
        ];
        $project->fill($data);
        $this->update($data, $project);

        $this->propStatus($project);
    }

    public function show(Project $project, $show = null): string {
        if ($project->status == 2 && $show) {
            $project->update(['status' => 3]);
            $this->propStatus($project);
        }

        return $this->path . $project->file;
    }

    public function confirm(Request $request, Project $project) {
        $this->deleteFile($project->file);
        $this->update([
            'status' => 5, 'file' => $this->uploadFile($request->file('file'))
        ], $project);

        $this->propStatus($project);
    }

    public function cancel(string $comment, Project $project) {
        $this->update(['status' => 4, 'comment' => $comment], $project);
        $this->propStatus($project);
    }

    private function uploadFile($file): string {
        return $this->storeFile($file);
    }

    private function propStatus(Project $project) {
        $proposition = $project->proposition;
        $proposition->update(['status' => $project->status + 9]);
        $proposition->applicant->update(['status' => $project->status + 9]);
    }
}
