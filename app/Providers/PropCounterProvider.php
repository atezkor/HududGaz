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
        View::composer('components.menu', function() {
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
            $numbers = match (request()->user()->role) {
                2, 7 => $this->technic(),
                default => [0, 0, 0, 0]
            };
            View::share(['numbers' => $numbers]);
        });
    }

    private function projects($organ): array {
        return $this->secondary(Project::query(), 'designer_id', $organ);
    }

    private function montages($organ): array {
        return $this->secondary(Montage::query(), 'mounter_id', $organ);
    }

    private function secondary(Builder $query, $column, $organ): array {
        $collection = $query->where($column, $organ)
            ->get('status')->groupBy('status');
        $counts = $this->countByGroup($collection, [1, 2, 4, 5, 3]);
        $counts[1] += $counts[4]; // Merge status 2 and 3 -  is process.

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
            ->whereIn('status', [Proposition::CREATED, Proposition::CREATED_T])
            ->count();

        $recs = Recommendation::query()
            ->where('organization_id', $organId)
            ->get('status')
            ->groupBy('status');
        $temp = $this->countByGroup($recs, [Recommendation::CREATED, 2, 3, 4]); // TODO status

        return [
            $propositions,
            $temp[0], $temp[1], $temp[2], $temp[3]
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
        foreach ($statuses as $key => $status) {
            if (isset($collection[$status]))
                $numbers[$key] = $collection[$status]->count();
            else
                $numbers[$key] = 0;
        }

        return $numbers;
    }

    private function technic(): array {
        return [
            Proposition::query()->whereDate('created_at', now())->count(),
            Proposition::query()->whereIn('status', [1, 2])->count(),
            Proposition::query()->where('created_at', '<',
                date(DATE_ATOM, time() - Status::query()->sum('term') * 3600))->count(),
            Proposition::query()->whereDate('created_at', '>', Carbon::now()->firstOfYear())->count()
        ];
    }
}
