<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class Sort extends Base
{
    protected string $defaultDirection = 'desc';

    protected array $fieldMap = [];

    /**
     * @param string $direction
     * @return $this
     */
    protected function defaultDirection(string $direction): static
    {
        $this->defaultDirection = $direction;

        return $this;
    }

    protected function fieldMap(array $map): static
    {
        $this->fieldMap = $map;

        return $this;
    }

    protected function getFieldMap(string $field)
    {
        return Arr::get($this->fieldMap, $field) ?? $field;
    }

    /**
     * @param string|array|int|float|bool|null $value
     * @return bool
     */
    public function shouldSkip(string|array|int|float|bool|null $value): bool
    {
        return empty($value);
    }

    protected function apply(BuilderContract $query, string|array|int|float|bool|null $value): BuilderContract
    {
        foreach ($value as $field => $direction) {
            $query->when(
                is_string($this->getFieldMap($field)),
                fn(Builder $q) => $q->orderBy($field, $direction ?? $this->defaultDirection)
            );
        }

        return $query;
    }
}
