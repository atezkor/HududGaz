<?php

namespace App\Providers;

use App\Models\Montage;
use App\Models\Project;
use App\Models\Proposition;
use App\Models\Recommendation;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Add this Class to config/app.php -> providers
 */
class PropCounterProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        // The reason of not using $user globally is auth()->user() returns null provider level

        View::composer('components.menu', function() {
            /* @var User $user */
            $user = request()->user();

            $numbers = match ($user->role_id) {
                User::ORGAN => $this->applications($user->organization_id),
//                User::DESIGNER => $this->projects($user->organization_id),
//                User::MOUNTER => $this->montages($user->organization_id),
                default => [0, 0, 0, 0, 0]
            };

            View::share(['numbers' => $numbers]);
        });

        View::composer('components.navbar', function() {
            /* @var User $user */
            $user = request()->user();

            $numbers = match ($user->role_id) {
                User::TECHNIC, User::DIRECTOR => $this->technic(),
                default => [0, 0, 0, 0]
            };
            View::share(['numbers' => $numbers]);
        });
    }

    private function projects($organId): array {
        return $this->secondary(Project::query(), 'designer_id', $organId);
    }

    private function montages($organId): array {
        return $this->secondary(Montage::query(), 'mounter_id', $organId);
    }

    private function secondary(Builder $query, $column, $organizationId): array {
        $collection = $query->where($column, $organizationId)
            ->get('status')->groupBy('status');
        $counts = $this->countByGroup($collection, [Project::CREATED, Project::ACCEPTED, Project::CANCELLED, Project::COMPLETED, Project::REVIEWED]);
        $counts[Project::CREATED] += $counts[Project::CANCELLED]; // Merge status 2 and 3 -  is process.

        return $counts;
    }


    /**
     * @param int $organId
     * @return array
     * This function for District role (Role(3)). Return count of Propositions and Recommendations
     */
    private function applications(int $organId): array {
        $propositions = Proposition::query()
            ->where('organization_id', $organId)
            ->whereIn('status', [Proposition::CREATED, Proposition::REVIEWED])
            ->count();

        $recs = Recommendation::query()
            ->where('organization_id', $organId)
            ->get('status')
            ->groupBy('status');
        $temp = $this->countByGroup($recs, [Recommendation::CREATED, Recommendation::PRESENTED, Recommendation::REJECTED, Recommendation::COMPLETED]);

        return [
            $propositions,
            $temp[Recommendation::CREATED],
            $temp[Recommendation::PRESENTED],
            $temp[Recommendation::REJECTED],
            $temp[Recommendation::COMPLETED]
        ];
    }

    /**
     * @param Collection $collection
     * @param array $statuses
     * @return array
     * This function processing collection and return array. Return count of collection
     */
    private function countByGroup(Collection $collection, array $statuses = []): array {
        $numbers = [];
        foreach ($statuses as $status) {
            if (isset($collection[$status]))
                $numbers[$status] = $collection[$status]->count();
            else
                $numbers[$status] = 0;
        }

        return $numbers;
    }

    private function technic(): array {
        $date = date(DATE_ATOM, time() - Status::query()->sum('term') * 3600);
        return [
            Proposition::query()->whereDate('created_at', now())->count(),
            Proposition::query()->whereIn('status', [Proposition::CREATED, Proposition::REVIEWED])->count(),
            Proposition::query()->where('created_at', '<', $date)->count(),
            Proposition::query()->whereDate('created_at', '>', Carbon::now()->firstOfYear())->count()
        ];
    }
}
