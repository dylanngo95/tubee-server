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
        $hash = $request->getAttribute('v');
        $link = "https://www.youtube.com/watch?v=$hash";

        $youtube = yield from $this->youtubeRepository->getYoutubeByHash($hash);

        if (!$youtube) {
            $this->youtubeRepository->saveYoutube($hash, $link);
            return Response::json([
                'data' => [
                    'link' => $link,
                    'status' => 'downloading'
                ]
            ]);
        }

        if ($youtube['status'] == 0) {
            return Response::json([
                'data' => [
                    'link' => $link,
                    'status' => 'downloading'
                ]
            ]);
        }

        $linkFull = 'htpp://localhost:8080/mp3/' . $youtube['name'];
        return Response::json([
            'data' => [
                'link' => $link,
                'link_download_mp3' => $linkFull,
                'status' => 'done'
            ]
        ]);
    }

    /**
     * Exec Shell.
     *
     * @param string $cmd
     * @return void
     */
    protected function execShellOnBackground(string $cmd)
    {
        if (str_starts_with(php_uname(), "Windows")) {
            pclose(popen("start /B " . $cmd, "r"));
        } else {
            exec($cmd . " > /dev/null &");
        }
    }
}