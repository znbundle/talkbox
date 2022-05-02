<?php

namespace ZnBundle\TalkBox\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;

class AnswerEntity implements ValidateEntityByMetadataInterface, EntityIdInterface
{

    private $id = null;
    private $requestText = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRequestText()
    {
        return $this->requestText;
    }

    public function setRequestText($requestText): void
    {
        $this->requestText = $requestText;
    }

}
