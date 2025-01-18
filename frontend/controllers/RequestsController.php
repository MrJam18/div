<?php

namespace frontend\controllers;

use common\models\request\UserRequest;
use common\models\request\UserRequestStatus;
use frontend\components\providers\RequestProvider;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class RequestsController extends Controller
{

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
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
            $time = (new \DateTime())->format('Y-m-d H:i:s');
            $userRequest->created_at = $time;
            $userRequest->updated_at = $time;
            $userRequest->user_request_status_id = UserRequestStatus::STATUS_ACTIVE;
            $userRequest->save();
            return $this->blankResponse();
        } else {
            return $this->validationErrorsResponse($userRequest);
        }
    }

    private function emptyRequestResponse(): Response
    {
        $response = $this->response;
        $response->statusCode = 400;
        $response->data = [
            'error' => 'request data is empty'
        ];
        return $response;
    }

    private function validationErrorsResponse(Model $model): Response
    {
        $response = $this->response;
        $response->statusCode = 400;
        $response->data = [
            'error' => 'validation error',
            'validationErrors' => $model->errors
        ];
        return $response;
    }

    private function blankResponse(int $statusCode = 200): Response
    {
        $response = $this->response;
        $response->statusCode = $statusCode;
        $response->content = '';
        return $response;
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



}