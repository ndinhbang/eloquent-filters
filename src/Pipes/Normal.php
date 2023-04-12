<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Http\Request;
use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Ndinhbang\EloquentFilters\Concerns\HasOperator;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Normal extends Base
{
    use HasOperator, HasColumn;

    public function __construct(
        protected Request $request,
        protected ?string $key,
        protected ?string $operator = null,
        protected array $columns = [],
        protected ?string $prefix = null,
        protected array   $ignores = [null, ''],
    )
    {
        parent::__construct($request, $key, $prefix, $ignores);
    }

    protected function apply(BuilderContract $query): BuilderContract
    {
        if (!$this->operator) {
            return $query->where($this->column(), $this->value());
        }
        return $query->where($this->column(), $this->operator, $this->value());
    }
}
