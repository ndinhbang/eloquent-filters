<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasColumn
{
    /**
     * @return string|null
     */
    public function column(): ?string
    {
        return !empty($columns = $this->getColumns()) ? $columns[0] : null;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns ?? ((array)$this->key);
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function setColumns(string ...$columns): static
    {
        $this->columns = $columns;

        return $this;
    }
}
