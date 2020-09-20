<?php

namespace ZnBundle\TalkBox\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class AnswerOptionEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $answerId = null;

    private $sort = 100;

    private $text = null;

    public function validationRules()
    {
        return [
            /*'id' => [
                new Assert\NotBlank,
            ],
            'answerId' => [
                new Assert\NotBlank,
            ],
            'sort' => [
                new Assert\NotBlank,
            ],
            'text' => [
                new Assert\NotBlank,
            ],*/
        ];
    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAnswerId($value) : void
    {
        $this->answerId = $value;
    }

    public function getAnswerId()
    {
        return $this->answerId;
    }

    public function setSort($value) : void
    {
        $this->sort = $value;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setText($value) : void
    {
        $this->text = $value;
    }

    public function getText()
    {
        return $this->text;
    }


}

