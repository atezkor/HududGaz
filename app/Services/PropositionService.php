<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;
use App\Models\Proposition;
use App\Models\Individual;
use App\Models\Legal;


class PropositionService extends CrudService {
    private string $path = 'storage/propositions';

    public function __construct(Proposition $model) {
        $this->model = $model;
        $this->folder = 'propositions';
    }

    public function create($data) {
        $data['file'] = $this->createFile($data['file']);
        parent::create($data);

        $data['proposition_id'] = $this->model->id;
        $this->createApplicant($data);
    }

    public function update($data, $model) {
        if (isset($data['file'])) {
            $data['file'] = $this->createFile($data['file']);
            $this->deleteFile($model->file);
        }
        parent::update($data, $model);

        $applicant = $model->applicant;
        $applicant->fill($data);
        $applicant->save();
    }

    public function delete($model) {
        $this->deleteFile($model->file);
        parent::delete($model); // $model->applicant->delete();
    }

    public function show(Proposition $proposition, int $status = 0): RedirectResponse {
        if ($status) {
            $this->update(['status' => $status], $proposition);

            $applicant = $proposition->applicant;
            $applicant->status = $status;
            $applicant->update();
        }
        return redirect($this->path . '/' . $proposition->getAttribute('file'));
    }

    private function createApplicant(array $data) {
        if (intval($data['type']) === 1)
            $model = new Individual();
        else
            $model = new Legal();
        $model->fill($data);
        $model->save();
    }

    protected function createFile($file): string {
        $name = time() . '.' . $file->extension();
        $file->move($this->path, $name); # Store to public folder
        return $name;
    }
}
