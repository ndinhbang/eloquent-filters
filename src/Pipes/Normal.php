<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Ndinhbang\EloquentFilters\Concerns\HasOperator;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Normal extends Base
{
    use HasOperator, HasColumn;

    protected function apply(BuilderContract $query): BuilderContract
    {
        if (!$this->operator) {
            return $query->where($this->column(), $this->value());
        }
        return $query->where($this->column(), $this->operator, $this->value());
    }
}
