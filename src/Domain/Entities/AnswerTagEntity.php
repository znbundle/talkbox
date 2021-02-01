<?php

namespace ZnBundle\TalkBox\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class AnswerTagEntity implements ValidateEntityByMetadataInterface, EntityIdInterface
{

    private $id = null;

    private $tagId = null;

    private $answerId = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('tagId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('answerId', new Assert\NotBlank);
    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTagId($value) : void
    {
        $this->tagId = $value;
    }

    public function getTagId()
    {
        return $this->tagId;
    }

    public function setAnswerId($value) : void
    {
        $this->answerId = $value;
    }

    public function getAnswerId()
    {
        return $this->answerId;
    }


}

