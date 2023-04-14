<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;

class Sort extends Base
{
    protected string $defaultDirection = 'desc';
    protected string $defaultSortField = 'id';

    public function __construct(
        Request $request,
        string  $paramKey = 'sort'
    )
    {
        parent::__construct($request);
        // Initial props
        $this->paramKey = $paramKey;
    }

    protected function shouldIgnore(string $paramKey): bool
    {
        return false;
    }

    protected function direction($direction)
    {
        $this->defaultDirection = $direction;
        return $this;
    }

    protected function field($field)
    {
        $this->defaultSortField = $field;
        return $this;
    }

    protected function apply(BuilderContract $query, string|array|int|float|bool|null $value): BuilderContract
    {
        if (!$this->value()) {
            return $query->orderBy($this->defaultSortField, $this->defaultDirection);
        }

        $values = is_array($this->value())
            ? $this->value()
            : ($this->value() ? (array)$this->value() : []);

        foreach ($values as $field => $direction) {
            if (is_numeric($field)) {
                $query->orderBy($direction, $this->defaultDirection);
            } else {
                $query->orderBy($field, $direction);
            }
        }

        return $query;
    }
}
