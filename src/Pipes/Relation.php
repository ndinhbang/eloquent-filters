<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;
use Ndinhbang\EloquentFilters\Concerns\HasColumn;

class Relation extends Base
{
    use HasColumn;

    public function __construct(
        protected Request $request,
        protected ?string $key,
        protected string $relation,
        protected array $columns = [],
        protected ?string $prefix = null,
        protected array   $ignores = [null, ''],
    )
    {
        parent::__construct($request, $key, $prefix, $ignores);
    }

    protected function apply(BuilderContract $query): BuilderContract
    {
        if (!$this->value()) {
            return $query;
        }

        $values = is_array($this->value())
            ? $this->value()
            : ($this->value() ? (array) $this->value() : []);

        return $query->whereHas($this->relation, function ($query) use ($values) {
            $query->whereIn($this->column(), $values);
        });
    }
}
