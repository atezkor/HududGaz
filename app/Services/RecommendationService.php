<?php

namespace App\Services;

use App\Models\Base;
use App\Models\Recommendation;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;


class RecommendationService extends CrudService {

    private string $path = 'storage/recommendations';
    private PDF $pdf;

    public function __construct(Recommendation $model, PDF $pdf) {
        $this->model = $model;
        $this->pdf = $pdf;
    }

    public function show($recommendation, $action = null): Response|RedirectResponse {
        if ($action)
            return redirect($this->path . '/');
        return $this->createPDF($recommendation);
    }

    public function upload($request, Recommendation $recommendation) {
        $recommendation->setAttribute('status', $recommendation->getAttribute('status') + 1);
        $recommendation->setAttribute('file', $this->createFile($request));
        $recommendation->update();
    }

    private function createPDF($recommendation): Response {
        $proposition = $recommendation->proposition();
        $organ = $recommendation->organ($proposition->organ);
        $applicant = $proposition->applicant();
        $district = Base::districts()[$organ->region];
        view()->share(['model' => $recommendation, 'proposition' => $proposition, 'organ' => $organ,
            'consumer' => $applicant, 'district' => $district]);

        $this->pdf->loadView('district.pdf.accept');
        return $this->pdf->download(time() . '.pdf');
    }

    private function createFile($request): string {
        // File::makeDirectory($this->path, 0777, true, true);
        $file = $request->file('file');
        $request->file('file')->store($this->path);
        return $file->getClientOriginalName();
    }

    function filter($status = 1): Collection {
       return $this->model->query()->where('status', '=', $status)
           ->get(['id', 'created_at']);
    }

    function propositions(Builder $model, int $status): Collection {
        return $model->where('status', '=', $status)
            ->get(['id', 'number', 'type', 'status']);
    }
}
