<?php

namespace ZnBundle\TalkBox\Commands;

use ZnBundle\TalkBox\Domain\Entities\TagEntity;
use ZnBundle\TalkBox\Domain\Services\TagService;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Base\Container\Helpers\ContainerHelper;

class SoundexCommand extends Command
{

    protected static $defaultName = 'dialog:soundex';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=white># Test</>');
        $container = ContainerHelper::getContainer();
        /** @var TagService $answerService */
        $answerService = $container->get(TagService::class);
        /** @var TagEntity[] | Collection $collection */
        $collection = $answerService->all();
        foreach ($collection as $tagEntity) {
            $answerService->updateById($tagEntity->getId(), [
                'soundex' => $tagEntity->getSoundex(),
                'metaphone' => $tagEntity->getMetaphone(),
            ]);
        }
        return Command::SUCCESS;
    }
}
