<?php

namespace App\Services;

use App\Models\Application;
use App\Models\LegalApplicant;
use App\Models\PhysicalApplicant;
use App\Models\Proposition;
use App\Utilities\StorageManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class PropositionService extends CrudService {
    use StorageManager;

    private string $path = 'storage/propositions';
    private string $folder;

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

    public function find(int $id): Model|Proposition {
        return Proposition::query()->find($id);
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

    public function view(Proposition $proposition, int $status = 0): string {
        if ($status && $proposition->status == Proposition::CREATED) {
            $this->update(['status' => $status], $proposition);
        }

        return $this->path . '/' . $proposition->getAttribute('pdf');
    }

    /**
     * Check that such tin has existed before.
     */
    public function checkTin(int $type, int $tin): array {
        if ($type == Application::PHYSICAL)
            return PhysicalApplicant::query()
                ->where('tin', $tin)
                ->pluck('tin', 'proposition_id')
                ->toArray();

        return LegalApplicant::query()
            ->where('tin', $tin)
            ->pluck('tin', 'proposition_id')
            ->toArray();
    }

    private function createApplicant(array $data) {
        if (intval($data['type']) === Application::PHYSICAL)
            $model = new PhysicalApplicant();
        else
            $model = new LegalApplicant();
        $model->fill($data);
        $model->save();
    }

    public function exist($type, $tin): Collection {
        return Proposition::query()
            ->whereHas($type == Application::PHYSICAL ? 'individual' : 'legal', function(Builder $query) use ($type, $tin) {
                if ($type == Application::PHYSICAL)
                    $query->where('tin', $tin);
                elseif ($type == Application::LEGAL)
                    $query->where('tin', $tin);
                else
                    $query->where('director_pin_fl', $tin);
            })
            ->get(['id', 'number', 'type', 'organization_id', 'created_at']);
    }
}
