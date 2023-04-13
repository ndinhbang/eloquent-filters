<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Support\Str;
use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Ndinhbang\EloquentFilters\Concerns\HasRelation;

class Relation extends Base
{
    use HasColumn, HasRelation;

    public function shouldIgnore(): bool
    {
        if (!$this->relation) {
            return true;
        }

        return parent::shouldIgnore();
    }

    protected function apply(BuilderContract $query): BuilderContract
    {
        if (empty($value = array_filter((array)$this->value()))) {
            return $query;
        }

        return $query->whereHas(
            Str::camel($this->relation),
            fn($query) => count($value) == 1
                ? $query->where($this->field(), $value[0])
                : $query->whereIn($this->field(), $value)
        );
    }
}
