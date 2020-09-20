<?php

namespace ZnBundle\TalkBox\Domain\Services;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use ZnBundle\TalkBox\Domain\Entities\AnswerEntity;
use ZnBundle\TalkBox\Domain\Helpers\WordHelper;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Libs\Container\ContainerAwareTrait;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Telegram\Domain\Helpers\MatchHelper;

class PredictService
{

    use ContainerAwareTrait;

    public function textToSentences(string $text): array
    {
        $sentences = WordHelper::textToSentences($text);
        $map = [];
        foreach ($sentences as $sentence) {
            try {
                $map[] = $this->textToWords($sentence);
            } catch (NotFoundException $e) {
            }
        }
        return $map;
    }

    public function textToWords(string $text): array
    {
        $text = MatchHelper::prepareString($text);
        $words = StringHelper::getWordArray($text);
        $container = Container::getInstance();
        $tagService = $container->get(TagService::class);
        $words = $tagService->normalizeWorlds($words);
        return $words;
    }

    public function predictText(string $request): string
    {
        $request = MatchHelper::prepareString($request);
        $words = StringHelper::getWordArray($request);
        $answerText = $this->predict($words);
        return $answerText;
    }

    public function predict(array $words): string
    {
        $container = Container::getInstance();

        /** @var TagService $tagService */
        $tagService = $container->get(TagService::class);
        $words = $tagService->normalizeWorlds($words);

        // todo: replace char `ё` to `е`
        $answerTextArray = $this->answersByWords($words);
        if (empty($answerTextArray)) {
            throw new NotFoundException('predict');
        }
        $count = count($answerTextArray);
        $index = mt_rand(0, $count - 1);
        return $answerTextArray[$index];
    }

    private function findEqual(Collection $answerCollection, array $words): AnswerEntity
    {
        foreach ($answerCollection as $answerEntity) {
            $text = MatchHelper::prepareString($answerEntity->getRequestText());
            $tags = StringHelper::getWordArray($text);
            if (count($tags) == count($words)) {
                $isEqual = empty(array_diff($tags, $words));
                if ($isEqual) {
                    return $answerEntity;
                }
            }
        }
        throw new NotFoundException('findEqual');
    }

    private function answerIdsByWords(array $words): array
    {
        $container = Container::getInstance();
        $tagService = $container->get(TagService::class);
        $tagCollection = $tagService->allByWorlds($words);
        if ($tagCollection->count() < count($words)) {
            throw new NotFoundException('answerIdsByWords');
        }
        $tagIds = EntityHelper::getColumn($tagCollection, 'id');
        $answerTagService = $container->get(AnswerTagService::class);
        $answerIds = $answerTagService->answerIdsByTagIds($tagIds);
        return $answerIds;
    }

    private function allOptionsByAnswerIds(array $answerIds, array $words): Collection
    {
        $container = Container::getInstance();
        $answerService = $container->get(AnswerService::class);
        $answerOptionService = $container->get(AnswerOptionService::class);
        /** @var Collection $answerCollection */
        $answerCollection = $answerService->allByIds($answerIds);
        $wordEntity = $this->findEqual($answerCollection, $words);
        if (empty($wordEntity)) {
            throw new NotFoundException('allOptionsByAnswerIds');
        }
        $optionCollection = $answerOptionService->allByAnswerIds([$wordEntity->getId()]);
        return $optionCollection;
    }

    private function answersByWords(array $words): array
    {
        $answerIds = $this->answerIdsByWords($words);
        if (count($answerIds) > 1000) {
            return null;
        }
        $optionCollection = $this->allOptionsByAnswerIds($answerIds, $words);
        $answerTextArray = EntityHelper::getColumn($optionCollection, 'text');
        return $answerTextArray;
    }

}
