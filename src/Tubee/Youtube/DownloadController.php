<?php

declare(strict_types=1);

namespace Tubee\Youtube;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class DownloadController
 */
class DownloadController
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        $video = $request->getAttribute('video');
        echo $video;
        $youtube = "https://www.youtube.com/watch?v=${video}";
        $this->execShell("cd /home/dylan/mp3s && youtube-dl --extract-audio --audio-format mp3 -o '%(title)s.%(ext)s' ${youtube}");

        return Response::plaintext(
            "Downloading " . $youtube . "!\n"
        );
    }

    protected function execShell($cmd) {
        if (substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen("start /B ". $cmd, "r"));
        }
        else {
            exec($cmd . " > /dev/null &");
        }
    }
}