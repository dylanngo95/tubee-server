<?php

declare(strict_types=1);

namespace Tubee\Book;

/**
 * Class Book
 */
class Book
{
    /** @readonly **/
    public string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }
}