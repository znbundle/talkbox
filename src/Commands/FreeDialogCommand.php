<?php

namespace ZnBundle\TalkBox\Commands;

use ZnBundle\TalkBox\Domain\__Handlers\DialogEventHandler;
use danog\MadelineProto\API;
use Illuminate\Container\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FreeDialogCommand extends Command
{

    protected static $defaultName = 'dialog:free';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=white># Free Dialog</>');
        $container = Container::getInstance();
        $api = $container->get(API::class);

        $api->startAndLoop(DialogEventHandler::class);
        return Command::SUCCESS;
    }

}
