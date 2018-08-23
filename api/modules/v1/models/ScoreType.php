<?php

namespace api\modules\v1\models;

class ScoreType implements ConstantsInterface
{
    const SIMPLE = 10;
    const MEDIUM = 20;
    const HARD = 30;

    public function getNames(): array
    {
        return [
            self::SIMPLE => "Оценка не влияет кол-во пыпыток",
            self::MEDIUM => "Максимальная оценка уменьшается вдвое при перездаче",
            self::HARD => "Одна попытка",
        ];
    }
}