<?php

declare(strict_types=1);

namespace Framework\Log\Writer;

/**
 * Class Stream
 */
class Stream
{
    /** @var false|resource */
    private $stream;

    /** @var string */
    private $fileUrl;

    /**
     * @throws \Exception
     */
    public function __construct(string $fileUrl = null)
    {
        if ($fileUrl) {
            $this->fileUrl = $fileUrl;
            $this->stream = fopen($this->fileUrl, "a+") or throw new \Exception("Unable to open file!");
        }
    }

    /**
     * @return resource
     * @throws \Exception
     */
    public function getWriter(string $fileUrl = null)
    {
        $this->fileUrl = $fileUrl;
        if (!$this->fileUrl) {
            throw new \Exception("File Url not exists!");
        }

        if (!$this->stream) {
            $this->stream = fopen($this->fileUrl, "a+") or throw new \Exception("Unable to open file!");
        }
        return $this->stream;
    }
}