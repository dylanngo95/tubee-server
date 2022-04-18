<?php

declare(strict_types=1);

namespace Framework\Log;

/**
 * Class Logger
 */
class Logger
{
    /** @var resource */
    private $stream;

    public function addWriter($stream)
    {
        $this->stream = $stream;
        return $this;
    }

    public function write($message)
    {
        if (!$this->stream) {
            return;
        }

        stream_set_blocking($this->stream, false);
        if (flock($this->stream, LOCK_EX)) {
            $time = new \DateTime();
            $time = $time->format('Y-m-d H:i:s u');
            fwrite($this->stream, "[${time}]: ${message}\n");
            flock($this->stream, LOCK_UN);
        }
    }

    public function close()
    {
        fclose($this->stream);
    }
}