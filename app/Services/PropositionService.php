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
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class PropositionService extends CrudService {
    use StorageManager;

    private string $path = 'storage/propositions';
    private string $folder;

    private ApplicantService $applicantService;

    public function __construct(Proposition $model, ApplicantService $applicantService) {
        $this->model = $model;
        $this->folder = 'propositions';

        $this->applicantService = $applicantService;
    }

    public function create($data) {
        try {
            DB::beginTransaction();
            if (isset($data['pdf'])) {
                $data['pdf'] = $this->createFile($this->path, $data['pdf']);
            }

            parent::create($data);

            $data['proposition_id'] = $this->model->id;
            $this->applicantService->create($data);
            DB::commit();
        } catch (QueryException $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    public function find(int $id): Model|Proposition {
        return Proposition::query()->find($id);
    }

    /**
     * @param $data
     * @param Proposition $model
     */
    public function update($data, $model) {
        if (isset($data['pdf'])) {
            $data['pdf'] = $this->createFile($this->path, $data['pdf']);
            $this->deleteFile($this->folder, $model->pdf);
        }
        parent::update($data, $model);

        if (isset($data['proposition_id'])) {
            $this->applicantService->update($data, $model->applicant);
        }
    }

    public function delete($model) {
        $this->deleteFile("storage/$this->folder/", $model->pdf);
        parent::delete($model);
    }

    public function view(Proposition $proposition, int $status = 0): string {
        if ($status && $proposition->status == Proposition::CREATED) {
            $this->update(['status' => $status], $proposition);
        }

        return $this->path . '/' . $proposition->pdf;
    }

    /**
     * Check that such tin has existed before.
     */
    public function checkTin(int $type, int $tinPin): Model {
        if ($type == Application::PHYSICAL)
            return PhysicalApplicant::query()
                ->with('propositions:id')
                ->where('pin_fl', $tinPin)
                ->firstOrNew();

        return LegalApplicant::query()
            ->with('propositions:id')
            ->where('tin', $tinPin)
            ->firstOrNew();
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
