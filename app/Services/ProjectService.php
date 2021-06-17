<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProjectService extends CrudService {
    private string $path = 'public/projects/';

    public function __construct(Project $model) {
        $this->model = $model;
        $this->folder = 'projects';
    }

    public function create($data) {
        $proposition = Proposition::query()
            ->where('status', 8)
            ->find($data);
        if (!$proposition)
            return;

        $applicant = $proposition->getAttribute('applicant');
        $condition = $proposition->getAttribute('tech_condition');
        $data = [
            'proposition_id' => $proposition->getAttribute('id'),
            'condition' => $condition->id,
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
        return Storage::url($this->path . $project->file);
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

    public function upload($request, Project $project) {
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
