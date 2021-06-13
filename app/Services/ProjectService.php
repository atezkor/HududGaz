<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Proposition;


class ProjectService extends CrudService {

    private string $path = 'public/projects/';

    public function __construct(Project $model) {
        $this->model = $model;
    }

    public function create($data) {
        $proposition = Proposition::query()
            ->where('number', $data['number'])
            ->where('status', 8)
            ->first();

        if (!$proposition)
            return;
        $data = [
            'proposition_id' => $proposition->getAttribute('id'),
            'applicant' => $proposition->getAttribute('applicant')->name,
            'organ' => auth()->user()->organ ?? 0
        ];
        $project = new Project($data);
        $project->save();
        $proposition->update(['status' => 10]);
        $proposition->getAttribute('applicant')->update(['status' => 10]);
    }

    public function upload($request, Project $project) {
        $data = [
            'file' => $this->uploadFile($request->file('file')),
            'status' => 2
        ];

        $project->fill($data);
        $project->proposition->update(['status' => 11]);
        $project->proposition->applicant->update(['status' => 11]);
        $this->update($data, $project);
    }

    private function uploadFile($file): string {
        $filename = time() . '.pdf';
        $file->storeAs($this->path, $filename);
        return $filename;
    }
}
