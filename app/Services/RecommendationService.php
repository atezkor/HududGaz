<?php

namespace App\Services;

use App\Models\Base;
use App\Models\Recommendation;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Response;


class RecommendationService extends CrudService {

//    private string $path = 'storage/recommendations';
    private PDF $pdf;

    public function __construct(Recommendation $model, PDF $pdf) {
        $this->model = $model;
        $this->pdf = $pdf;

    }

    public function show($recommendation): Response {
        return $this->createPDF($recommendation);
    }

    public function upload($request) {

    }

    private function createPDF($recommendation): Response {
        $proposition = $recommendation->proposition();
        $organ = $recommendation->organ($proposition->organ);
        $consumer = $proposition->consumer($proposition->type);
        $districts = Base::districts();
        view()->share(['model' => $recommendation, 'proposition' => $proposition, 'organ' => $organ,
            'consumer' => $consumer, 'districts' => $districts]);

        $this->pdf->loadView('district.pdf.accept');
        return $this->pdf->download(time() . '.pdf');
    }

//    File::makeDirectory($this->path, 0777, true, true);
}
