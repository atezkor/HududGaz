<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Montage;
use App\Models\TechCondition;


class MontageService extends CrudService {

    public function __construct(Montage $model) {
        $this->model = $model;
        $this->folder = 'montages';
    }

    public function create($data): string {
        $condition = TechCondition::query()->where('status', 2)
            ->where('qrcode', $data)->first();
        if (!$condition)
            return "Yoq";
        $proposition = $condition->getAttribute('proposition');
        if ($proposition->status >= 14)
            return "Yoq";

        $applicant = $proposition->applicant;
        $data = [
            'proposition_id' => $proposition->id,
            'condition' => $condition->getAttribute('id'),
            'project' => $condition->project->id,
            'applicant' => $applicant->name,
            'firm' => auth()->user()->organ ?? 0,
            'organ' => $proposition->organ
        ];
        $montage = new Montage($data);
        $montage->save();

        $proposition->update(['status' => 15]);
        $applicant->update(['status' => 15]);

        return "Bor";
    }

    public function upload(Request $request, Montage $montage) {
        if ($request->has('diameter')) {
            $montage->proposition->recommendation->update(['pipe2' => $request->get('diameter')]);
            return;
        }

        if ($this->model->file)
            $this->deleteFile($this->model->file);
        $montage->update(['status' => 2, 'file' => $this->storeFile($request->file('file'))]);
        $this->propStatus($montage, 19);
    }

    public function show(Montage $montage, $show = false): string {
        if ($montage->status == 2 && $show) {
            $montage->update(['status' => 3]);
            $this->propStatus($montage, 18);
        }

        return Storage::url("$this->folder/" . $montage->file);
    }

    public function confirm(Request $request, Montage $montage) {
        $this->deleteFile($montage->file);
        $this->update([
            'status' => 4, 'file' => $this->storeFile($request->file('file'))
        ], $montage);
        $this->propStatus($montage, 17);
    }

    public function cancel(string $comment, Montage $montage) {
        $this->update(['status' => 3, 'comment' => $comment], $montage);
        $this->propStatus($montage, 18);
    }

    private function propStatus(Montage $montage, int $status) {
        $proposition = $montage->proposition;
        $proposition->update(['status' => $status]);
        $proposition->applicant->update(['status' => $status]);
    }
}
