<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Database\Eloquent\Builder;
use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Ndinhbang\EloquentFilters\Concerns\HasRange;

class Range extends Base
{
    use HasColumn, HasRange;

    protected function apply(BuilderContract $query, string|array|int|float|bool|null $value): BuilderContract
    {
        [$start, $end] = $value;

        if ($start == $end) {
            return $query->where($this->field(), $start);
        }

        return $query
            ->when($start, function (Builder $query) use ($start) {
                $query->where($this->field(), $this->includeStart ? '>=' : '>', $start);
            })->when($end, function (Builder $query) use ($end) {
                $query->where($this->field(), $this->includeEnd ? '<=' : '<', $end);
            });
    }
}
