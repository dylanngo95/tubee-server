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
    private Environment $environment;
    private YoutubeRepository $youtubeRepository;

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
        $video = $request->getAttribute('v');
        $youtube = yield from $this->youtubeRepository->getNameByHash($video);
        if ($youtube) {
            $linkFull = 'htpp://localhost:8080/mp3/' . $youtube;
            return Response::json([
                'data' => [
                    'link' => $linkFull
                ]
            ]);
        }

        $youtube = "https://www.youtube.com/watch?v=${video}";
        $command = "cd " . PB . " && bin/tubee ${youtube}";
        $this->execShellOnBackground($command);

        return Response::json([
            'data' => 'downloading ' . $youtube
        ]);
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