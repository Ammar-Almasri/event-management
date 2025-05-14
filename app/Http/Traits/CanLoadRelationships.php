<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
trait CanLoadRelationships
{
    protected function IncludeRelation(array $allowed)
    {
        $requested = request()->query('include');

        if (!$requested) {
            return [];
        }

        $requested = array_map('trim', explode(',', $requested));

        return array_intersect($allowed, $requested);
    }

    public function loadRelationships(
        Model|QueryBuilder|EloquentBuilder|HasMany $for,
        ?array $allowed = []
    ): Model|QueryBuilder|EloquentBuilder|HasMany {
        // Get the valid relations
        $relations = $this->IncludeRelation($allowed);

        if (empty($relations) && property_exists($this, 'allowed')) {
            $relations = $this->IncludeRelation($this->allowed);
        }

        if ($for instanceof Model) {
            // Load all the relations at once for a specific model instance
            $for->load($relations);
        } else {
            // Eager load all the relations at once for a query
            $for->with($relations);
        }

        return $for;
    }
}

