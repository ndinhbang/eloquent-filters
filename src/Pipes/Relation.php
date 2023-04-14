<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Support\Str;
use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Ndinhbang\EloquentFilters\Concerns\HasRelation;

class Relation extends Base
{
    use HasColumn, HasRelation;

    public function shouldSkip(string|array|int|float|bool|null $value): bool
    {
        if (!$this->relation) {
            return true;
        }

        return parent::shouldSkip($value);
    }

    protected function apply(BuilderContract $query, string|array|int|float|bool|null $value): BuilderContract
    {
        return $query->whereHas(
            Str::camel($this->relation),
            fn($query) => (!is_array($value) || count($value) == 1)
                ? $query->where($this->field(), $value)
                : $query->whereIn($this->field(), $value)
        );
    }
}
