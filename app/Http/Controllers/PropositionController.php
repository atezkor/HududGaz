<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropositionRequest;
use App\Models\Proposition;
use App\Models\User;
use App\Services\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PropositionController extends Controller {

    private Service $service;

    public function __construct() {
        $this->service = new Service(new Proposition());
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse {
        $models = User::all();
        return view('propositions.index', ['models' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse {
        return view('propositions.test');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PropositionRequest $request
     * @return RedirectResponse
     */
    public function store(PropositionRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);
        return redirect()->route('technic.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Proposition $proposition
     * @return View|RedirectResponse
     */
    public function show(Proposition $proposition): View|RedirectResponse {
        return view('propositions.index', ['model' => $proposition]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Proposition $proposition
     * @return View|RedirectResponse
     */
    public function edit(Proposition $proposition): View|RedirectResponse {
        return view('technic', ['model' => $proposition]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PropositionRequest $request
     * @param Proposition $proposition
     * @return RedirectResponse
     */
    public function update(PropositionRequest $request, Proposition $proposition): RedirectResponse {
        $data = $request->validated();
        $this->service->update($data, $proposition);
        return redirect()->route('technic.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Proposition $proposition
     * @return RedirectResponse
     */
    public function destroy(Proposition $proposition): RedirectResponse {
        $this->service->delete($proposition);
        return redirect()->route('technic.index');
    }
}
