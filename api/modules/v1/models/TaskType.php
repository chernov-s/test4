<?php

namespace api\modules\v1\models;

class TaskType implements ConstantsInterface
{
    const INPUT = 10;
    const SELECT = 20;

    public function getNames(): array
    {
        return [
            self::INPUT => "input",
            self::SELECT => "select",
        ];
    }
}