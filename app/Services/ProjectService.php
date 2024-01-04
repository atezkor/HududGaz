<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\Project;
use App\Models\Proposition;
use App\Models\TechCondition;
use App\Models\User;
use App\Utilities\FileUploadManager;
use App\Utilities\StorageManager;
use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Generator;


class ProjectService extends CrudService {
    use FileUploadManager, StorageManager;

    private string $path = '/storage/projects/';
    private string $directory;

    private Generator $qrcode;

    public function __construct(Project $model, Generator $qrcode) {
        $this->model = $model;
        $this->directory = 'projects';

        $this->qrcode = $qrcode;
    }

    /**
     * @param array $data
     */
    public function create($data): void {
        /**
         * @var User $user
         * @var TechCondition $condition
         */
        $user = auth()->user();

        $code = $data['code'];
        $condition = TechCondition::query()
            ->where('qrcode', $code)
            ->whereHas('proposition', function(Builder $query) {
                return $query->where('status', Proposition::PROJECT_C);
            })->firstOrFail();

        $proposition = $condition->proposition;
        $data = [
            'proposition_id' => $proposition->id,
            'applicant_id' => $condition->applicant_id,
            'tech_condition_id' => $condition->id,
            'designer_id' => $user->organization_id,
            'organ_id' => $proposition->organization_id
        ];

        $proposition->update(['status' => Proposition::PROJECT_CREATED]);

        $project = new Project($data);
        $project->save();
    }

    public function upload($file, Project $project) {
        if ($project->pdf)
            $this->deleteFile($this->directory, $project->pdf);

        $data = [
            'pdf' => $this->store($file['pdf'], $this->directory),
            'status' => Project::ACCEPTED
        ];

        $project->fill($data);
        $this->update($data, $project);
        $this->propStatus($project);
    }

    public function generateLetter(Project $project): array {
        $proposition = $project->proposition;
        $recommendation = $proposition->recommendation;

        return [
            'proposition' => $proposition,
            'applicant' => $proposition->applicant,
            'recommendation' => $proposition->recommendation,
            'build_type' => $proposition->buildType(),
            'condition' => $project->condition,
            'organization' => Organization::Data()->shareholder_name,
            'gas_meters' => [], //$recommendation->GasMeters(),
            'equipments' => [] //$recommendation->getEquipments()
        ];
    }

    public function show(Project $project, $show = null): string {
        if ($project->status == Project::ACCEPTED && $show) {
            $project->update(['status' => Project::REVIEWED]);
            $this->propStatus($project);
        }

        return $this->path . $project->pdf;
    }

    public function confirm($file, Project $project) {
        $this->deleteFile($this->directory, $project->pdf);
        $this->update([
            'status' => Project::COMPLETED,
            'pdf' => $this->store($file, $this->directory)
        ], $project);

        $this->propStatus($project);
    }

    public function cancel(Project $project, string $comment) {
        $this->update(['status' => Project::CANCELLED, 'comment' => $comment], $project);
        $this->propStatus($project);
    }

    public function delete($model) {
        $this->propStatus($model, 7);
        parent::delete($model);
    }

    public function qrcode(User $user) {
        return $this->qrcode->size(500)->generate(json_encode([
            'token' => $user->getLastToken(),
            'url' => route('designer.project.create_api', ['user' => $user->id])
        ]));
    }

    private function propStatus(Project $project, $status = Proposition::PROJECT_CANCELLED) {
        $proposition = $project->proposition;
        $proposition->update(['status' => $project->status + $status]);
    }

    public function GasMeters() {
        $equipments = json_decode($this->getAttribute('equipments'));
        if (!$equipments)
            return [];

        foreach ($equipments as $key => $equipment) {
            if ($equipment->equipment != 1) {
                unset($equipments[$key]);
                continue;
            }

            $equipment->equipment = $this->equipment($equipment->equipment, true);
            if (!$equipment->equipment) {
                unset($equipments[$key]);
                continue;
            }
            $equipment->type = $this->equipType($equipment->type);
        }

        return $equipments;
    }
}
