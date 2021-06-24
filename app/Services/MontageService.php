<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Montage;
use App\Models\Permit;
use App\Models\Organization;
use App\Models\TechCondition;
use Barryvdh\DomPDF\PDF;


class MontageService extends CrudService {

    private PDF $pdf;
    public function __construct(Montage $model, PDF $pdf) {
        $this->model = $model;
        $this->folder = 'montages';
        $this->pdf = $pdf;
    }

    public function create($data): string {
        $condition = TechCondition::query()->where('qrcode', $data)
            ->whereHas('proposition', function(Builder $query) {
                $query->where('status', 14);
            })->first();
        if (!$condition)
            return "Yoq";

        $proposition = $condition->getAttribute('proposition');
        $applicant = $proposition->applicant;
        $data = [
            'proposition_id' => $proposition->id,
            'condition' => $condition->getAttribute('id'),
            'project' => $condition->getAttribute('project')->id,
            'applicant' => $applicant->name,
            'firm' => auth()->user()->organ ?? 0,
            'organ' => $proposition->organ
        ];
        $montage = new Montage($data);
        $montage->save();

        $proposition->update(['status' => 15]); $applicant->update(['status' => 15]);

        return "Bor";
    }

    public function upload(Request $request, Montage $montage) {
        if ($request->has('diameter')) {
            $montage->proposition->recommendation->update(['pipe2' => $request->get('diameter')]);
            return;
        }

        $data = $request->validate(['file' => ['required']]);
        if ($this->model->file)
            $this->deleteFile($this->model->file);
        $montage->update(['status' => 2, 'file' => $this->storeFile($data['file'])]);
        $this->propStatus($montage);
    }

    public function show(Montage $montage, $show = false): string {
        if ($montage->status == 2 && $show) {
            $montage->update(['status' => 3]);
            $this->propStatus($montage);
        }

        return Storage::url("$this->folder/" . $montage->file);
    }

    public function confirm(Request $request, Montage $montage) {
        $this->deleteFile($montage->file);
        $this->update([
            'status' => 5, 'file' => $this->storeFile($request->file('file'))
        ], $montage);
        $this->createLicense($montage);
    }

    public function cancel(string $comment, Montage $montage) {
        $this->update(['status' => 4, 'comment' => $comment], $montage);
        $this->propStatus($montage);
    }

    public function delete($model) {
        $this->propStatus($model, -$model->status);
        parent::delete($model);
    }

    private function propStatus(Montage $montage, $status = 14) {
        $proposition = $montage->proposition;
        $proposition->update(['status' => $montage->status + $status]);
        $proposition->applicant->update(['status' => $montage->status + $status]);
    }

    private function createLicense(Montage $montage) {
        $proposition = $montage->proposition;
        $permit = new Permit([
            'proposition_id' => $proposition->id,
            'applicant' => $proposition->applicant->name,
            'project' => $montage->project_relation->id,
            'montage' => $montage->id,
            'district' => $proposition->org->region,
        ]);
        $permit->save();

        /* Create permit */
        $this->propStatus($montage);
        $this->createPDF($permit);
    }

    private function createPDF(Permit $permit) {
        $filename = time() . '.pdf';
        $proposition = $permit->proposition;
        $data = [
            'permit' => $permit,
            'proposition' => $proposition,
            'recommendation' => $proposition->recommendation,
            'organization' => Organization::Data(),
            'designer' => $permit->project_relation->firm->org_name,
            'installer' => $permit->montage_relation->mounter->short_name,
            'district' => districts()[$permit->district],
            'meters' => $proposition->recommendation->GasMeters(),
            'equipments' => $proposition->recommendation->getEquipments()
        ];

        view()->share($data);
        $this->pdf->loadView('engineer.permit')->save('storage/permits/' . $filename);
        $permit->update(['file' => $filename]);
    }
}
