<?php

namespace App\Services;

use App\Models\Individual;
use App\Models\Legal;
use App\Models\Proposition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;


class PropositionService extends CrudService {
    private string $path = 'storage/propositions';

    public function __construct(Proposition $model) {
        $this->model = $model;
    }

    public function show($proposition): RedirectResponse {
        return redirect($this->path . '/' . $proposition->file);
    }

    public function create($data) {
        $data['file'] = $this->createFile($data['file']);
        parent::create($data);
        $data['proposition_id'] = $this->model->getAttribute('id');
        $this->createProposition($data);
    }

    public function update($data, $model) {
        if (isset($data['file'])) {
            $data['file'] = $this->createFile($data['file']);
            $this->deleteFile($model->file);
        }
        parent::update($data, $model);
        if ((int) $model->type === 1)
            $applicant = $model->individual();
        else
            $applicant = $model->legal();
        $applicant->fill($data);
        $applicant->save();
    }

    public function delete($model) {
        parent::delete($model);
        $this->deleteFile($model->file);
    }

    private function createProposition($data) {
        if (intval($data['type']) == 1) {
            $model = new Individual();
        } else {
            $model = new Legal();
        }
        $model->fill($data);
        $model->save();
    }

    private function createFile($file): string {
        $name = time() . '.' . $file->extension();
        $file->move($this->path, $name); # Store to public folder
        // $file->storeAs($this->path, $name); # Store to storage folder

        return $name;
    }

    private function deleteFile($file) {
        File::delete($this->path . '/' . $file);
    }
}
