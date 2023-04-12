<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Ndinhbang\EloquentFilters\Concerns\HasOperator;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
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

    protected function apply(BuilderContract $query): BuilderContract
    {
        if (!$this->operator) {
            return $query->where($this->column(), $this->value());
        }
        return $query->where($this->column(), $this->operator, $this->value());
    }
}
