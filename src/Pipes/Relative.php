<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ndinhbang\EloquentFilters\Concerns\HasColumn;

class Relative extends Base
{
    use HasColumn;
    /**
     * see https://dev.mysql.com/doc/refman/8.0/en/fulltext-boolean.html
     */
    protected function textWildcards(string $term): string
    {
        return Str::ascii($term) . '%';
    }

    protected function apply(BuilderContract $query): BuilderContract
    {
        $search = $this->value();
        if (!$search) {
            return $query;
        }
        // wildcards
        $search = $this->textWildcards($search);

        return $query->where(function ($query) use ($search) {
            foreach ($this->getColumns() as $index => $column) {
                $query->when(
                    $index > 0,
                    fn($q) => $q->orWhere($column, 'like', $search),
                    fn($q) => $q->where($column, 'like', $search),
                );
            }
        });
    }
}
