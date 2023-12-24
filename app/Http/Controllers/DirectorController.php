<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Proposition;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


class DirectorController extends Controller {

    public function index(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('director.index', [
            'models' => $this->propositionsCount(),
        ]);
    }

    public function permits(): View|RedirectResponse {
        try {
            $this->authorize('show_document');
        } catch (AuthorizationException) {
            return redirect('/');
        }

        return view('engineer.permits', [
            'models' => License::all(),
            'districts' => districts()
        ]);
    }

    public function propositionsCount(): array {
        $models = Proposition::query()->select(
            "id",
            DB::raw("(count(id)) as count"),
            DB::raw("(DATE_FORMAT(created_at, '%m')) as month")
        )->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            ->get();

        $data = [];
        $j = 0;
        $count = $models->count();
        for ($i = 1; $i <= 12; $i++) {
            if ($j < $count) {
                if ((int)$models[$j]->month == $i) {
                    $data[$i] = $models[$j]->count;
                    $j++;
                    continue;
                }
            }

            $data[$i] = 0;
        }
        unset($models);

        return $data;
    }
}
