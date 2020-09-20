<?php

namespace ZnBundle\TalkBox\Domain\Actions;

use ZnLib\Telegram\Domain\Entities\RequestEntity;
use ZnLib\Telegram\Domain\Base\BaseAction;
use ZnLib\Telegram\Domain\Entities\MessageEntity;
use ZnLib\Telegram\Domain\Helpers\MatchHelper;
use danog\MadelineProto\APIFactory;
use ZnCore\Base\Helpers\StringHelper;

class SearchAction extends BaseAction
{

    private $patterns;

    public function __construct(array $patterns)
    {
        parent::__construct();
        $this->patterns = $patterns;
    }

    public function run(RequestEntity $requestEntity)
    {
        $request = $requestEntity->getMessage();
        $request = MatchHelper::prepareString($request);
        foreach ($this->patterns as $pattern) {
            $request = str_replace($pattern, '', $request);
        }
        $request = preg_replace('/([\W]+)/ui', ' ', $request);
        $request = MatchHelper::prepareString($request);
        $request = str_replace(' ', '+', $request);
        ///$request = StringHelper::vectorizeText($request);
        yield $this->response->sendMessage('http://www.google.ru/search?hl=ru&q=' . $request);
        /*yield $this->messages->sendMessage([
            'peer' => $update,
            'message' => ,
            // 'https://ru.wikipedia.org/w/index.php?sort=relevance&search='.$request.'&fulltext=1'
            //'message' => implode(PHP_EOL, $sentences),
            //'reply_to_msg_id' => isset($update['message']['id']) ? $update['message']['id'] : null,
        ]);*/
    }

}