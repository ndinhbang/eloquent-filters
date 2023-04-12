<?php

namespace Ndinhbang\EloquentFilters\Contracts;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

interface Pipe
{
    public function handle(BuilderContract $query): BuilderContract;
}
