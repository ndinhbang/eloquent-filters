<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Ndinhbang\EloquentFilters\Concerns\HasMultiColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Relative extends Base
{
    use HasMultiColumn;

    public function __construct(
        Request $request,
        string $paramKey)
    {
        parent::__construct($request);
        // Initial props
        $this->paramKey = $paramKey;
    }

    /**
     * see https://dev.mysql.com/doc/refman/8.0/en/fulltext-boolean.html
     */
    protected function textWildcards(string $term): string
    {
        return Str::ascii($term) . '%';
    }

    protected function apply(Builder $query): Builder
    {
        $search = $this->value();
        if (!$search) {
            return $query;
        }
        // wildcards
        $search = $this->textWildcards($search);

        return $query->where(function ($query) use ($search) {
            foreach ($this->columns() as $index => $column) {
                $query->when(
                    $index > 0,
                    fn($q) => $q->orWhere($column, 'like', $search),
                    fn($q) => $q->where($column, 'like', $search),
                );
            }
        });
    }
}
