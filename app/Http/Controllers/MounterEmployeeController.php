<?php

namespace App\Http\Controllers;

use App\Http\Requests\FitterRequest;
use App\Models\Fitter;
use App\Services\Mounter\MounterEmployeeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class MounterEmployeeController extends Controller {

    private MounterEmployeeService $service;

    public function __construct(MounterEmployeeService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse {
        $firmId = $request->get('firm_id');
        if (!$firmId) {
            return redirect()->route('admin.mounters.index');
        }

        return view('admin.mounters.employees.index', [
            'models' => $this->service->all($firmId),
            'firm_id' => $firmId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function create(Request $request): View|RedirectResponse {
        $model = new Fitter();
        $firm = $request->get('firm');

        return view('admin.mounters.employees.create', [
            'action' => route('admin.mounter.employees.store'),
            'method' => 'POST',
            'model' => $model,
            'firm_id' => $firm
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FitterRequest $request
     * @return RedirectResponse
     */
    public function store(FitterRequest $request): RedirectResponse {
        $data = $request->validated();
        $this->service->create($data);

        $firm = $request->get('firm_id');
        return redirect()->route('admin.fitters.index', ['firm' => $firm]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Fitter $fitter
     * @return View|RedirectResponse
     */
    public function edit(Fitter $fitter): View|RedirectResponse {
        return view('admin.mounters.manage', [
            'action' => route('admin.fitters.update', ['fitter' => $fitter]),
            'method' => 'PUT',
            'model' => $fitter
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FitterRequest $request
     * @param Fitter $fitter
     * @return RedirectResponse
     */
    public function update(FitterRequest $request, Fitter $fitter): RedirectResponse {
        $data = $request->validated();
        $this->service->update($fitter, $data);

        $firm = $request->get('firm_id');
        return redirect()->route('admin.fitters.index', ['firm' => $firm]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Fitter $fitter
     * @return RedirectResponse
     */
    public function destroy(Fitter $fitter): RedirectResponse {
        $this->service->delete($fitter);
        return redirect()->route('admin.fitters.index', [
            'firm' => $fitter->getAttribute('firm_id')
        ]);
    }
}
