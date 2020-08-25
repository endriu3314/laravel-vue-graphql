<?php

namespace App\GraphQL\Queries;

use App\Book;

class SomeComplexQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the
        return Book::where('author', 'like', '%'.$args['search'].'%')->get();
    }
}
