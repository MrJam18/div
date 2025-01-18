<?php

namespace common\models\request;

use yii\db\ActiveRecord;

class UserRequestStatus extends ActiveRecord
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_RESOLVED = 2;
}