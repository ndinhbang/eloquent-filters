<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;
use Ndinhbang\EloquentFilters\Concerns\HasColumn;

class Relation extends Base
{
    use HasColumn;

    private string $relation;

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns ?? ((array)$this->key);
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
