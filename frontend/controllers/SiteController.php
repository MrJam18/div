<?php

namespace frontend\controllers;

use app\controllers\ApiController;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends ApiController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'signup' => ['post'],
                    'login' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin(): Response
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->getUser();
            $user->generateAuthKey();
            $user->save();
            return $this->asJson(['auth_key' => $user->auth_key]);
        }
        return $this->validationErrorsResponse($model);
    }

    public function actionSignup(): Response
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            $user = User::findByUsername($model->username);
            return $this->asJson([
                'auth_key' => $user->auth_key,
            ]);
        }

        return $this->validationErrorsResponse($model);
    }
}
