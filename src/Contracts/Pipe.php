<?php

namespace Ndinhbang\EloquentFilters\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Pipe
{
    public function handle(Builder $query): Builder;
}
