<?php

namespace App\Services;

use App\Models\Organization;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\TechCondition;


class ProjectService extends CrudService {
    private string $path = '/storage/projects/';

    public function __construct(Project $model) {
        $this->model = $model;
        $this->folder = 'projects';
    }

    public function create($data, $user = null): string {
        $id = auth()->user()->organ ?? $user;
        if ($id == null)
            return __('global.msg.no_allow');

        $condition = TechCondition::query()->where('qrcode', $data)
            ->whereHas('proposition', function(Builder $query) {
                return $query->where('status', 8);
            })->first();
        if (!$condition)
            return __('global.msg.not_found');

        $proposition = $condition->getAttribute('proposition');
        $applicant = $proposition->applicant;
        $data = [
            'proposition_id' => $proposition->id,
            'condition' => $condition->getAttribute('id'),
            'applicant' => $applicant->name,
            'organ' => $proposition->organ,
            'designer' => $id
        ];
        $project = new Project($data);
        $project->save();

        $proposition->update(['status' => 10]); $applicant->update(['status' => 10]);
        return __('global.messages.crt');
    }

    public function upload(Request $request, Project $project) {
        $file = $request->validate(['file' => ['required']]);
        if ($project->file)
            $this->deleteFile($project->file);
        $data = [
            'file' => $this->uploadFile($file['file']),
            'status' => 2
        ];
        $project->fill($data);
        $this->update($data, $project);

        $this->propStatus($project);
    }

    public function generateLetter(Project $project): View {
        $proposition = $project->proposition;
        $recommendation = $proposition->recommendation;
        return view('designer.explanatory-letter', [
            'proposition' => $proposition, 'applicant' => $proposition->applicant,
            'recommendation' => $proposition->recommendation,
            'build_type' => $proposition->buildType(),
            'condition' => $proposition->tech_condition,
            'organization' => Organization::Data()->shareholder_name,
            'gas_meters' => $recommendation->GasMeters(),
            'equipments' => $recommendation->getEquipments()
        ]);
    }

    public function show(Project $project, $show = null): string {
        if ($project->status == 2 && $show) {
            $project->update(['status' => 3]);
            $this->propStatus($project);
        }

        return $this->path . $project->file;
    }

    public function confirm(Request $request, Project $project) {
        $this->deleteFile($project->file);
        $this->update([
            'status' => 5, 'file' => $this->uploadFile($request->file('file'))
        ], $project);

        $this->propStatus($project);
    }

    public function cancel(string $comment, Project $project) {
        $this->update(['status' => 4, 'comment' => $comment], $project);
        $this->propStatus($project);
    }

    public function delete($model) {
        $this->propStatus($model, 7);
        parent::delete($model);
    }

    private function uploadFile($file): string {
        return $this->storeFile($file);
    }

    private function propStatus(Project $project, $status = 9) {
        $proposition = $project->proposition;
        $proposition->update(['status' => $project->status + $status]);
        $proposition->applicant->update(['status' => $project->status + $status]);
    }
}
