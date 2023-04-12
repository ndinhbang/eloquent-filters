<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Ndinhbang\EloquentFilters\Concerns\HasMultiColumn;
use Illuminate\Http\Request;

/**
 * Make sure to set mysql config below, then run optimize table
 * @see https://dev.mysql.com/doc/refman/8.0/en/fulltext-fine-tuning.html
 *
 * [mysqld]
 * ...
 * innodb_ft_min_token_size=2
 * ft_min_word_len=2
 * ft_stopword_file=''
 * innodb_ft_enable_stopword=OFF
 * ...
 *
 */
class FullText extends Base
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
    protected function fullTextWildcards(string $term): string
    {
        $term = trim($term);
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~', '.'];
        $term = str_replace($reservedSymbols, ' ', $term);
        $term = preg_replace('/\s+/', ' ',$term);
        $words = explode(' ', $term);

        $searchterms = [];
        foreach ($words as $word) {
            if (mb_strlen($word) > 1) {
                $searchterms[] = '+' . $word . '*';
            }
        }

        return !empty($searchterms)
            ? implode(' ', $searchterms)
            : '';

    }

    protected function apply(BuilderContract $query): BuilderContract
    {
        $search = $this->fullTextWildcards($this->value());
        if (!$search) {
            return $query;
        }

        return $query->whereFullText(
            $this->columns(),
            $search,
            [
                'mode' => 'boolean', // IN BOOLEAN MODE
//                'expanded' => true, // WITH QUERY EXPANSION
            ]
        );
    }
}
