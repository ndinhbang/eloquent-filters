<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;

class Relation extends Base
{
    private string $relation;

    public function __construct(
        Request $request,
        string $paramKey,
        string $relation)
    {
        parent::__construct($request);
        // Initial props
        $this->paramKey = $paramKey;
        $this->relation = $relation;
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
