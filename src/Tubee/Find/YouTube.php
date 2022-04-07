<?php

declare(strict_types=1);

namespace Tubee\Find;

use Framework\DataObject;

/**
 * Class YouTube
 */
class YouTube extends DataObject
{
    /**
     * @return int
     */
    public function getId()
    {
        return self::getData('id');
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        self::setData('id', $id);
        return $this;
    }
}