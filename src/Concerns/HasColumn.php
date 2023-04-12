<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasColumn
{
    protected ?string $column = null;

    public function column(?string $key = null): string|static
    {
        if (is_null($key)) {
            return $this->column ?? $this->paramKey;
        }

        $this->column = $key;

        return $this;
    }
}
