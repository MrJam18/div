<?php

namespace frontend\controllers;

use app\controllers\ApiController;
use common\models\request\UserRequest;
use common\models\request\UserRequestStatus;
use frontend\components\providers\RequestProvider;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RequestsController extends ApiController
{

    public function behaviors(): array
    {
        return [
            'basicAuth' => [
                'class' => HttpBearerAuth::class,
                'only' => ['index', 'update'],
            ],
            'accessControl' => [
                'class' => AccessControl::class,
                'only' => ['index', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'update'],
                        'roles' => ['responsible'],
                    ]
                ],
            ],
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => [Yii::$app->params['externalSiteUrl']],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 86400,
                ],
            ],
        ];
    }

    public function actionCreate(): Response
    {
        $userRequest = new UserRequest();
        $userRequest->scenario = UserRequest::SCENARIO_CREATE;
        if(!$userRequest->load($this->request->post())) {
            return $this->emptyRequestResponse();
        } elseif ($userRequest->validate()) {
            $userRequest->user_request_status_id = UserRequestStatus::STATUS_ACTIVE;
            $userRequest->save();
            return $this->blankResponse();
        } else {
            return $this->validationErrorsResponse($userRequest);
        }
    }

    public function actionIndex(RequestProvider $provider): Response
    {
        if($provider->validate()) {
            $data = $provider->search();
            $this->response->data = $data;
            return $this->response;
        } else {
            return $this->validationErrorsResponse($provider);
        }
    }

    public function actionUpdate(int $id): Response
    {
        $model = UserRequest::findOne($id);
        if($model === null) {
            throw new NotFoundHttpException("can't find the user-request with id {$id}");
        }
        $model->scenario = UserRequest::SCENARIO_RESOLVE;
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->user_request_status_id = UserRequestStatus::STATUS_RESOLVED;
            $model->responsible_user_id = Yii::$app->user->id;
            $model->save();
            \Yii::$app->mailer->compose('@app/email/requests/reply', [
                'model' => $model,
            ])->setFrom(\Yii::$app->params['adminEmail'])
                ->setTo($model->email)
                ->setSubject('Ответ на заявку')
                ->send();
            return $this->blankResponse();
        } else {
            return $this->validationErrorsResponse($model);
        }

    }



}