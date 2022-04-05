<?php

declare(strict_types=1);

namespace Tubee\Youtube;

use Framework\Config\Environment;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

/**
 * Class YoutubeController
 */
class YoutubeController
{
    /**
     * @var Environment $environment
     */
    protected $environment;

    /**
     * @var YoutubeRepository $youtubeRepository
     */
    private $youtubeRepository;

    /**
     * @param Environment $environment
     * @param YoutubeRepository $youtubeRepository
     */
    public function __construct(
        Environment $environment,
        YoutubeRepository $youtubeRepository
    ) {
        $this->environment = $environment;
        $this->youtubeRepository = $youtubeRepository;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $video = $request->getAttribute('video');
        $videoName = yield from $this->youtubeRepository->getName($video);

        $staticPath = $this->environment->getStaticPath();
        $youtube = "https://www.youtube.com/watch?v=${video}";
        $this->execShellOnBackground("cd ${staticPath}/mp3 && youtube-dl --extract-audio --audio-format mp3 -o '%(title)s.%(ext)s' ${youtube}");

        return Response::plaintext(
            "Downloading " . $youtube . "!\n"
        );
    }

    /**
     * Exec Shell.
     *
     * @param string $cmd
     * @return void
     */
    protected function execShellOnBackground(string $cmd) {
        if (str_starts_with(php_uname(), "Windows")){
            pclose(popen("start /B ". $cmd, "r"));
        }
        else {
            exec($cmd . " > /dev/null &");
        }
    }
}