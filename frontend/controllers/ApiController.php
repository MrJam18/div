<?php

namespace app\controllers;

use yii\base\Model;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{

    protected function emptyRequestResponse(): Response
    {
        $response = $this->response;
        $response->statusCode = 400;
        $response->data = [
            'error' => 'request data is empty'
        ];
        return $response;
    }

    protected function validationErrorsResponse(Model $model): Response
    {
        $response = $this->response;
        $response->statusCode = 400;
        $response->data = [
            'error' => 'validation error',
            'validationErrors' => $model->errors
        ];
        return $response;
    }

    protected function blankResponse(int $statusCode = 200): Response
    {
        $response = $this->response;
        $response->statusCode = $statusCode;
        $response->content = '';
        return $response;
    }
}