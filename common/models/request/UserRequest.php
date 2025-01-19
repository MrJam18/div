<?php

namespace common\models\request;

use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $user_request_status_id
 * @property string $message
 * @property ?string $comment
 * @property int $created_at
 * @property int $updated_at
 * @property ?int $responsible_user_id
 *
 * @property UserRequestStatus $status
 * @property User $responsibleUser
 */
class UserRequest extends ActiveRecord
{
    public const SCENARIO_CREATE = 'create';
    public const SCENARIO_RESOLVE = 'resolve';

    public function rules(): array
    {
        return [
          [['name', 'email', 'message', 'comment',], 'string'],
          ['name', 'string', 'length' => [4, 24]],
          ['email', 'email'],
          [['name', 'email', 'message', 'comment'], 'required'],
        ];
    }

    public function scenarios(): array
    {
        return [
            self::SCENARIO_CREATE => ['name', 'email', 'message'],
            self::SCENARIO_RESOLVE => ['name', 'email', 'message', 'comment'],
        ];
    }

    public function beforeSave($insert): bool
    {
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $this->updated_at = $now;
        if($insert) {
            $this->created_at = $now;
        }
        return parent::beforeSave($insert);
    }

    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(UserRequestStatus::class, ['id' => 'user_request_status_id']);
    }

    public function getResponsibleUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'responsible_user_id']);
    }

    public function formName(): string
    {
        return '';
    }


}