<?php

namespace common\models;

use yii\db\ActiveRecord;

class CustomModel extends ActiveRecord
{
    public function formName(): string
    {
        return '';
    }
}