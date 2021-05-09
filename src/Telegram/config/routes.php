<?php

return [
    [
        'matcher' => new \ZnLib\Telegram\Domain\Matchers\AnyMatcher(),
        'action' => new \ZnBundle\TalkBox\Telegram\Actions\DataBaseAction(),
        'help' => '
Ифнобот реагирует, если понимает фразу.
Он может ответить на распространенные вопросы, на пример:
привет!
сколько тебе лет?
как дела?
Может понять, даже если вы написали слова с ошибками.
Перестановка слов местами мало на что влияет.',
    ],
];
