<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Ndinhbang\EloquentFilters\Concerns\HasOperator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Normal extends Base
{
    use HasColumn, HasOperator;

    public function __construct(
        Request $request,
        string $paramKey
    )
    {
        parent::__construct($request);
        // Initial props
        $this->paramKey = $paramKey;
    }

    protected function apply(Builder $query): Builder
    {
        if (!$this->operator) {
            return $query->where($this->column(), $this->value());
        }
        return $query->where($this->column(), $this->operator, $this->value());
    }
}
