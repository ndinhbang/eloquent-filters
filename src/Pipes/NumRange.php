<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Ndinhbang\EloquentFilters\Concerns\HasRange;

class NumRange extends Base
{
    use HasColumn, HasRange;

    /**
     * @param string|array|int|float|bool|null $value
     * @return bool
     */
    public function shouldSkip(string|array|int|float|bool|null $value): bool
    {
        if (empty($value) || !is_array($value)) {
            return true;
        }

        return false;
    }

    protected function apply(BuilderContract $query, string|array|int|float|bool|null $value): BuilderContract
    {
        return $query->where($this->field(), $value ? 1 : 0);
    }
}
