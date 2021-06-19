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
        $applicant = $proposition->applicant;
        $data = [
            'proposition_id' => $proposition->id,
            'condition' => $condition->getAttribute('id'),
            'applicant' => $applicant->name,
            'organ' => auth()->user()->organ ?? 0
        ];
        $montage = new Montage($data);
        $montage->save();

        $data = ['status' => 15, 'organ' => $montage->organ];
        $proposition->update($data);
        $applicant->update($data);

        return "Bor";
    }

    public function show(Montage $montage): string {
        return Storage::url($this->folder . $montage->file);
    }

    public function confirm(Request $request, Montage $montage) {
        $this->deleteFile($montage->file);
        $this->update([
            'status' => 4, 'file' => $this->uploadFile($request->file('file'))
        ], $montage);
        $this->updateProposition($montage, ['status' => 17]);
    }

    public function cancel(string $comment, Montage $montage) {
        $this->update(['status' => 3, 'comment' => $comment], $montage);
        $this->updateProposition($montage, ['status' => 18]);
    }

    public function upload(Request $request, Montage $montage) {

    }

    private function uploadFile($file): string {
        return $this->storeFile($file);
    }

    private function updateProposition(Montage $montage, array $data = []) {
        $proposition = $montage->proposition;
        $proposition->update($data);
        $proposition->applicant->update($data);
    }
}
