<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Montage;
use App\Models\Project;
use App\Models\Proposition;
use App\Models\Recommendation;

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
            $numbers = match($user->role) {
                3 => $this->organs($user->organ),
                4 => $this->projects($user->organ),
                6 => $this->montages($user->organ),
                default => [0, 0, 0, 0, 0]
            };

            View::share(['numbers' => $numbers]);
        });
    }

    private function projects($organ): array {
        return $this->secondary(Project::query(), 'designer', $organ);
    }

    private function montages($organ): array {
        return $this->secondary(Montage::query(), 'firm', $organ);
    }

    private function secondary(Builder $query, $column, $organ): array {
        $collection = $query->where($column, $organ)
            ->get('status')->groupBy('status');
        $counts = $this->countByGroup($collection, [1, 2, 4, 5, 3]);
        $counts[1] += $counts[4]; // Merge status 2 and 3 -  is process.

        return $counts;
    }


    /**
     * @param int $organ
     * @return array
     * This function for District role (Role(3)). Return count of Propositions and Recommendations
     */
    private function organs(int $organ): array {
        $recs = Recommendation::query()->where('organ', $organ)
            ->get('status')->groupBy('status');
        $temp = $this->countByGroup($recs, [1, 2, 3, 4]);

        return [
            Proposition::query()->where('organ', $organ)
                ->whereIn('status', [1, 2])->count(),
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
}
