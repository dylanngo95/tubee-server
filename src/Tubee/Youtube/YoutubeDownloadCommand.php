<?php

declare(strict_types=1);

namespace Tubee\Youtube;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class YoutubeCommand
 */
class YoutubeDownloadCommand extends Command
{
    public function __construct(
        string $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('youtube:download')
            ->setDescription('Command support download youtube video in background');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Start downloading');
        $youtubeDownload = new YoutubeDownload();
        $youtubeDownload->download();
        $output->writeln('Done');

        return Command::SUCCESS;
    }
}