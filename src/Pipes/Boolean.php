<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Ndinhbang\EloquentFilters\Concerns\HasColumn;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

class Boolean extends Base
{
    use HasColumn;

    protected function apply(BuilderContract $query, string|array|int|float|bool|null $value): BuilderContract
    {
        return $query->where($this->field(), $value ? 1 : 0);
    }
}
