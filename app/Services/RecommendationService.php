<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Organization;
use App\Models\Recommendation;
use Barryvdh\DomPDF\PDF;


class RecommendationService extends CrudService {

    private string $path = 'public/recommendations';
    private PDF $pdf;

    public function __construct(Recommendation $model, PDF $pdf) {
        $this->model = $model;
        $this->pdf = $pdf;
    }

    public function show(Recommendation $recommendation): Response {
        return $this->createPDF($recommendation);
    }

    /**
     * This function allows the person to see the file
     */
    public function techShow(Recommendation $recommendation): RedirectResponse {
        $proposition = $recommendation->proposition;
        if ($proposition->status == 4) {
            $proposition->update(['status' => 5]);
            $proposition->applicant->update(['status' => 5]);
        }

        return redirect(Storage::url($this->path . '/' . $recommendation->getAttribute('file')));
    }

    public function upload($request, Recommendation $recommendation) {
        $recommendation->setAttribute('status', 2);
        $recommendation->setAttribute('file', $this->createFile($request->file('file')));
        $recommendation->update();
    }

    public function accept() {

    }


    /**
     * This function for back recommendation to District
     */
    public function back(Recommendation $recommendation, string $comment) {
        $recommendation->setAttribute('comment', $comment);
        $recommendation->setAttribute('status', 3);
        $recommendation->update();

        $recommendation->proposition->update(['status' => 6]);
        $recommendation->proposition->applicant->update(['status' => 6]);
    }

    public function update($data, $model) {
        $this->deleteFile($model->file);
        $data['status'] = 1;
        if (isset($data['file']))
            $data['file'] = $this->createFile($data['file']);

        parent::update($data, $model);
    }

    private function createPDF(Recommendation $recommendation): Response {
        $proposition = $recommendation->proposition;
        $organ = $recommendation->organ($proposition->organ);
        $applicant = $proposition->applicant;
        $district = districts()[$organ->getAttribute('region')];
        $organization = Organization::Data();

        $data = ['model' => $recommendation, 'proposition' => $proposition, 'organ' => $organ, 'consumer' => $applicant,
            'district' => $district, 'organization' => $organization];

        if ($recommendation->type == 'accept') {
            $equipments = json_decode($recommendation->getAttribute('equipments'), true);
            foreach ($equipments as $key => $equipment) {
                $equipments[$key]['equipment'] = Equipment::query()->where('id', '=', $equipment['equipment'])->pluck('name')[0];
                $equipments[$key]['type'] = EquipmentType::query()->where('id','=', $equipment['type'])->pluck('type')[0];
            }

            $data['equipments'] = $equipments;
        }

        view()->share($data);

        $this->pdf->loadView('district.pdf.' . $recommendation->type);
        return $this->pdf->stream(time() . '.pdf');
    }

    private function createFile($file): string {
        // File::makeDirectory($this->path, 0777, true, true);
        $file->storeAs($this->path, $file->getClientOriginalName());
        return $file->getClientOriginalName();
    }

    private function deleteFile($file) {
        File::delete($this->path . '/' . $file);
    }

    function filter(int $status, string $operator, int $organ): Collection {
        $add = request()->route()->getName() == "district.recommendations.cancelled";
        $models = $this->model->query()->where('organ', $operator, $organ)
            ->where('status', '=', $status)
            ->orderBy('proposition_id');
       return $add ? $models->get(['id', 'comment']) : $models->pluck('id');
    }

    function propositions(Builder $model, array $status, string $operator, int $organ): \Illuminate\Database\Eloquent\Collection {
        return $model->where('organ', $operator, $organ)
            ->whereIn('status', $status)
            ->get(['id', 'number', 'type', 'status', 'organ', 'created_at']);
    }
}
