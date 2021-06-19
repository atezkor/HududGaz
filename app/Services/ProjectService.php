<?php

namespace App\Services;

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
        $condition = TechCondition::query()->where('status', 2)
            ->where('qrcode', $data)->first();
        if (!$condition)
            return;

        $proposition = $condition->getAttribute('proposition');
        $applicant = $proposition->applicant;
        $data = [
            'proposition_id' => $proposition->id,
            'condition' => $condition->getAttribute('id'),
            'applicant' => $applicant->name,
            'organ' => auth()->user()->organ ?? 0
        ];
        $project = new Project($data);
        $project->save();

        $data = ['status' => 10, 'organ' => $project->organ];
        $proposition->update($data);
        $applicant->update($data);
    }

    public function show(Project $project): string {
        return $this->path . $project->file;
    }

    public function confirm(Request $request, Project $project) {
        $this->deleteFile($project->file);
        $this->update([
            'status' => 4, 'file' => $this->uploadFile($request->file('file'))
        ], $project);

        $proposition = $project->proposition;
        $proposition->update(['status' => 14]);
        $proposition->applicant->update(['status' => 14]);
    }

    public function cancel(string $comment, Project $project) {
        $this->update(['status' => 3, 'comment' => $comment], $project);

        $proposition = $project->proposition;
        $proposition->update(['status' => 13]);
        $proposition->applicant->update(['status' => 13]);
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

        $proposition = $project->proposition;
        $proposition->update(['status' => 11]);
        $proposition->applicant->update(['status' => 11]);
    }

    private function uploadFile($file): string {
        return $this->storeFile($file);
    }
}
