<?php
namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
use yii\db\Exception;

class RbacController extends Controller
{
    public function actionInit(): void
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $responsible = $auth->createRole('responsible');
        $responsible->description = 'responsible';
        $auth->add($responsible);

        $responsibleUsers = User::findAll(['type' => User::TYPE_RESPONSIBLE]);
        foreach ($responsibleUsers as $responsibleUser) {
            $auth->assign($responsible, $responsibleUser->id);
        }
    }

    public function actionMakeResponsible($username): void
    {
        $user = User::findOne(['username' => $username]);
        if (!$user) {
            throw new Exception('user does not exist');
        }
        $user->type = User::TYPE_RESPONSIBLE;
        $user->save();
        $auth = Yii::$app->authManager;
        $responsible = $auth->getRole('responsible');
        $auth->assign($responsible, $user->id);
        echo "OK\n";
    }
}