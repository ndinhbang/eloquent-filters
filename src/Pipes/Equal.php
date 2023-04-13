<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Equal extends Base
{
    use HasColumn;

    protected function apply(BuilderContract $query): BuilderContract
    {
        if (!is_array($value = $this->value())
            || (is_array($value) && count($value) == 1)) {
            return $query->where($this->field(), $value);
        }
        return $query->whereIn($this->field(), $value);
    }
}
