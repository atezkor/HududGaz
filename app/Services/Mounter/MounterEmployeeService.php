<?php

namespace App\Services\Mounter;

use App\Models\Fitter;
use App\Services\Core\ICrudService;
use App\Utilities\StorageManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class MounterEmployeeService implements ICrudService {
    use StorageManager;

    private Model $model;

    public function __construct() {
        $this->model = new Fitter();
    }

    public function all(int $firmId): Collection {
        return Fitter::query()
            ->where('firm_id', '=', $firmId)
            ->get();
    }

    /* Fitters */
    public function create(array $data) {
        $data['license'] = $this->createFile('storage/mounters/workers', $data['license']);
        $this->model->fill($data);
        $this->model->save();
    }

    /**
     * @param Fitter $model
     * @param array $data
     */
    public function update($model, array $data) {
        if (isset($data['license'])) {
            $data['license'] = $this->createFile('storage/mounters/workers', $data['license']);
        }

        $model->update($data);
    }

    public function delete(Model $model) {
        /* @var Fitter $model */
        $this->deleteFile("storage/mounters/workers", $model->license);
        $model->delete();
    }
}
