<?php

namespace App\Services;

use App\Models\Individual;
use App\Models\Legal;
use App\Models\Proposition;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;


class PropositionService extends CrudService {
    private string $path = 'storage/propositions';

    public function __construct(Proposition $model) {
        $this->model = $model;
    }

    public function create($data) {
        $data['file'] = $this->createFile($data['file']);
        parent::create($data);
        $data['proposition_id'] = $this->model->getAttribute('id');
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
        $this->deleteApplicant($model);
        $this->deleteFile($model->file);
        parent::delete($model);
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
        if (intval($data['type']) === 1) {
            $model = new Individual();
        } else {
            $model = new Legal();
        }
        $model->fill($data);
        $model->save();
    }

    private function deleteApplicant($model) {
        $applicant = $model->applicant;
        $this->deleteFile($applicant->file);
        $applicant->delete();
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

    public function filter(int $type, array $statuses, string $operator, int $organ): Collection {
        return $this->model->query()->where('organ', $operator, $organ)
            ->where('type', '=', $type)
            ->whereIn('status', $statuses)
            ->get();
    }
}
