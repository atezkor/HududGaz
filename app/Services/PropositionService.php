<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Individual;
use App\Models\LegalProposition;
use App\Models\Proposition;
use App\Utilities\StorageManager;


class PropositionService extends CrudService {
    use StorageManager;

    private string $path = 'storage/propositions';

    public function __construct(Proposition $model) {
        $this->model = $model;
        $this->folder = 'propositions';
    }

    public function create($data) {
        $data['file'] = $this->createFile($this->path, $data['file']);
        parent::create($data);

        $data['proposition_id'] = $this->model->id;
        $this->createApplicant($data);
    }

    public function update($data, $model) {
        if (isset($data['file'])) {
            $data['file'] = $this->createFile($this->path, $data['file']);
            $this->deleteFile($this->folder, $model->file);
        }
        parent::update($data, $model);

        $applicant = $model->applicant;
        $applicant->fill($data);
        $applicant->save();
    }

    public function delete($model) {
        $this->deleteFile("storage/$this->folder/", $model->file);
        parent::delete($model);
    }

    public function show(Proposition $proposition, int $status = 0): string {
        if ($status) {
            $this->update(['status' => $status], $proposition);

            $applicant = $proposition->applicant;
            $applicant->status = $status;
            $applicant->update();
        }

        return $this->path . '/' . $proposition->getAttribute('file');
    }

    private function createApplicant(array $data) {
        if (intval($data['type']) === 1)
            $model = new Individual();
        else
            $model = new LegalProposition();
        $model->fill($data);
        $model->save();
    }

    public function available($type, $stir): array {
        return Proposition::query()->whereHas($type == 1 ? 'individual' : 'legal', function(Builder $query) use ($type, $stir) {
            if ($type == 1)
                $query->where('stir', $stir);
            elseif ($type == 2)
                $query->where('legal_stir', $stir);
            else
                $query->where('leader_stir', $stir);
        })->get(['id', 'number', 'type', 'organ', 'created_at']);
    }
}
