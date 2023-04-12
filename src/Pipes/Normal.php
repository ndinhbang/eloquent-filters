<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Http\Request;
use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Ndinhbang\EloquentFilters\Concerns\HasOperator;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Normal extends Base
{
    use HasOperator, HasColumn;

    protected function apply(BuilderContract $query): BuilderContract
    {
        if (empty($this->operator)) {
            return $query->where($this->field(), $this->value());
        }
        return $query->where($this->field(), $this->operator, $this->value());
    }
}
