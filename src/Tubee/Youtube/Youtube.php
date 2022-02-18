<?php

declare(strict_types=1);

namespace Tubee\Youtube;

/**
 * Class Youtube
 */
class Youtube
{
    public $id;
    public $hash;
    public $name;
    public $link;
    public $status;

    public function __construct($id, $hash, $name, $link, $status)
    {
        $this->id = $id;
        $this->hash = $hash;
        $this->name = $name;
        $this->link = $link;
        $this->status = $status;
    }
}