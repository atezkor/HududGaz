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

    public function create($data): void {
        /**
         * @var TechCondition $condition
         * @var User $user
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
            'tech_condition_id' => $condition->id,
            'organ' => $proposition->organ,
            'designer_id' => $user->organization_id
        ];

        $project = new Project($data);
        $project->save();

        $proposition->update(['status' => Proposition::PROJECT_CREATED]);
    }

    public function upload($file, Project $project) {
        if ($project->pdf)
            $this->deleteFile($this->directory, $project->pdf);

        $data = [
            'pdf' => $this->store($file['file'], $this->directory),
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
            'gas_meters' => $recommendation->GasMeters(),
            'equipments' => $recommendation->getEquipments()
        ];
    }

    public function show(Project $project, $show = null): string {
        if ($project->status == 2 && $show) {
            $project->update(['status' => 3]);
            $this->propStatus($project);
        }

        return $this->path . $project->pdf;
    }

    public function confirm($file, Project $project) {
        $this->deleteFile($this->directory, $project->pdf);
        $this->update([
            'status' => Project::COMPLETED,
            'file' => $this->store($file, $this->directory)
        ], $project);

        $this->propStatus($project);
    }

    public function cancel(string $comment, Project $project) {
        $this->update(['status' => Project::CANCELLED, 'comment' => $comment], $project);
        $this->propStatus($project);
    }

    public function delete($model) {
        $this->propStatus($model, 7);
        parent::delete($model);
    }

    public function qrcode(User $user) {
        return $this->qrcode->generate(json_encode([
            'token' => $user->getLastToken(),
            'url' => route('designer.project.create_api', ['user' => $user->id])
        ]));
    }

    private function propStatus(Project $project, $status = 9) {
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
