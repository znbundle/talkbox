<?php

namespace ZnBundle\TalkBox\Domain\Services;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use ZnBundle\TalkBox\Domain\Entities\TagEntity;
use ZnBundle\TalkBox\Domain\Interfaces\Repositories\TagRepositoryInterface;
use ZnBundle\TalkBox\Domain\Interfaces\Services\TagServiceInterface;
use ZnBundle\TalkBox\Domain\Libs\Parser;

use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Base\Text\Helpers\TextHelper;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnCore\Domain\Query\Entities\Where;
use ZnCore\Domain\Query\Enums\OperatorEnum;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Domain\Query\Entities\Query;
use ZnLib\Telegram\Domain\Libs\SoundexRuEn;

class TagService extends BaseCrudService implements TagServiceInterface
{

    public function __construct(EntityManagerInterface $em, TagRepositoryInterface $repository)
    {
        $this->setEntityManager($em);
        $this->setRepository($repository);
    }

    public function import(Container $container)
    {

        $dataBaseText = file_get_contents(__DIR__ . '/../../../../config/answer_databse');
        $parser = new Parser;
        $collection = $parser->parseFromText($dataBaseText);

        /** @var \ZnBundle\TalkBox\Domain\Interfaces\Services\TagServiceInterface $tagService */
        $tagService = $container->get(\ZnBundle\TalkBox\Domain\Services\TagService::class);

        /** @var \ZnBundle\TalkBox\Domain\Interfaces\Services\AnswerServiceInterface $answerService */
        $answerService = $container->get(\ZnBundle\TalkBox\Domain\Services\AnswerService::class);

        /** @var \ZnBundle\TalkBox\Domain\Interfaces\Services\AnswerTagServiceInterface $answerTagService */
        $answerTagService = $container->get(\ZnBundle\TalkBox\Domain\Services\AnswerTagService::class);

        /** @var \ZnBundle\TalkBox\Domain\Interfaces\Services\AnswerOptionServiceInterface $answerOptionService */
        $answerOptionService = $container->get(\ZnBundle\TalkBox\Domain\Services\AnswerOptionService::class);

        foreach ($collection as $token => $answer) {

            $answerEntity = $answerService->oneByRequestTextOrCreate($token);

            echo PHP_EOL . $token . PHP_EOL;
            //$tags = explode(' ', $token);
            $tags = TextHelper::getWordArray($token);
            foreach ($tags as $tag) {

                $tagEntity = $tagService->oneByWordOrCreate($tag);

                try {
                    $answerTagService->create([
                        'tag_id' => $tagEntity->getId(),
                        'answer_id' => $answerEntity->getId(),
                    ]);
                } catch (\Exception $e) {
                }
            }
            foreach ($answer as $option) {
                try {
                    $answerOptionService->create([
                        'answer_id' => $answerEntity->getId(),
                        'text' => $option['answer'],
                        'sort' => intval($option['sort']) * 100,
                    ]);
                } catch (\Exception $e) {
                }
            }
        }
    }

    private function filterTagCollection(string $word, Collection $tagCollection): string
    {
        if ($tagCollection->count() > 1) {
            $ratingByLevenshtein = [];
            $ratingBySimilar = [];
            foreach ($tagCollection as $tagEntity) {
                $itemWord = $tagEntity->getWord();
                $ratingByLevenshtein[$itemWord] = levenshtein($word, $tagEntity->getWord());
                $ratingBySimilar[$itemWord] = similar_text($word, $tagEntity->getWord());
            }
            $firstWord = ArrayHelper::firstKey($ratingByLevenshtein);
        } else {
            $firstWord = $tagCollection->first()->getWord();
        }
        return $firstWord;
    }

    public function normalizeWorlds(array $words): array
    {
        $soundex = new SoundexRuEn;
        $newWords = [];
        foreach ($words as $word) {
            $query = new Query;
            $query->whereNew(new Where('soundex', $soundex->encodeSoundex($word), OperatorEnum::EQUAL, 'or'));
            $query->whereNew(new Where('metaphone', $soundex->encodeMetaphone($word), OperatorEnum::EQUAL, 'or'));
            /** @var TagEntity[] | Collection $tagCollection */
            $tagCollection = parent::findAll($query);
            if ($tagCollection->count() > 0) {
                $newWords[] = $this->filterTagCollection($word, $tagCollection);
            }
        }
        return $newWords;
    }

    public function allByWorlds(array $words, Query $query = null): Collection
    {
        $query = new Query;
        $query->with(['answer']);
        $query->where('word', $words);
        return parent::findAll($query);
    }

    public function oneByWordOrCreate(string $word): TagEntity
    {
        $query = new Query;
        $query->where('word', $word);
        $collection = $this->getRepository()->findAll($query);
        if ($collection->count() === 0) {
            $entity = $this->createEntity();
            $entity->setWord($word);
            $this->getRepository()->create($entity);
        } else {
            $entity = $collection->first();
        }
        return $entity;
    }

}
