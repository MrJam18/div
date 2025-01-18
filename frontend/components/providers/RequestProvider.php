<?php
namespace frontend\components\providers;

use common\models\request\UserRequest;
use common\models\request\UserRequestStatus;
use yii\base\Model;
use yii\filters\AccessControl;

class RequestProvider extends Model
{
    public ?string $status = null;
    public ?string $created_at = null;

    public function rules(): array
    {
        return [
          ['status', 'in', 'range' => ['Active', 'Resolved']],
          ['status', 'filter', 'filter' => function ($value) {
            switch ($value) {
                case 'Active':
                    return UserRequestStatus::STATUS_ACTIVE;
                case 'Resolved':
                        return UserRequestStatus::STATUS_RESOLVED;
                default:
                    return null;
            }
          }],
          [['created_at'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function __construct($config = [])
    {
        if(!$config) {
            $config = \Yii::$app->request->get();
        }
        parent::__construct($config);
    }

    public function search(): array
    {
        $query = UserRequest::find();
        $query->andFilterWhere([
            'user_request_status_id' => $this->status,
        ])->andFilterWhere([
            'between', 'created_at', $this->created_at . ' 00:00:00', $this->created_at . ' 23:59:59',
        ]);
        return $query->asArray()->all();
    }
}