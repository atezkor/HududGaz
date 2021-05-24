<?php

namespace App\Services;

use App\Models\Base;
use App\Models\Recommendation;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;


class RecommendationService extends CrudService {

    private string $path = 'public/recommendations';
    private PDF $pdf;

    public function __construct(Recommendation $model, PDF $pdf) {
        $this->model = $model;
        $this->pdf = $pdf;
    }

    public function show($recommendation, $action = null): Response|RedirectResponse {
        if ($action) {
//            $this->update(['status' => 5], $recommendation->proposition);
            return redirect(Storage::url($this->path . '/' . $recommendation->file));
        }
        return $this->createPDF($recommendation);
    }

    public function upload($request, Recommendation $recommendation) {
        $recommendation->setAttribute('status', $recommendation->getAttribute('status') + 1);
        $recommendation->setAttribute('file', $this->createFile($request));
        $recommendation->update();
    }

    public function accept() {

    }

    public function back(Recommendation $recommendation, string $comment) {
        $recommendation->setAttribute('comment', $comment);
        $recommendation->update(['status' => 3]);
        $recommendation->proposition()->update(['status' => 6]);
    }

    private function createPDF($recommendation): Response {
        $proposition = $recommendation->proposition();
        $organ = $recommendation->organ($proposition->organ);
        $applicant = $proposition->applicant();
        $district = Base::districts()[$organ->region];
        view()->share(['model' => $recommendation, 'proposition' => $proposition, 'organ' => $organ,
            'consumer' => $applicant, 'district' => $district]);

        $this->pdf->loadView('district.pdf.' . $recommendation->type);
        return $this->pdf->download(time() . '.pdf');
    }

    private function createFile($request): string {
        // File::makeDirectory($this->path, 0777, true, true);
        $file = $request->file('file');
        $request->file('file')->storeAs($this->path, $file->getClientOriginalName());
        return $file->getClientOriginalName();
    }

    function filter(int $status): Collection {
       return $this->model->query()->where('status', '=', $status)
           ->orderBy('proposition_id')->get(['id', 'created_at', 'comment']);
    }

    function propositions(Builder $model, array $status): Collection {
        return $model->whereIn('status', $status)
            ->get(['id', 'number', 'type', 'status', 'created_at']);
    }
}
