<?php

use common\models\request\UserRequest;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var UserRequest $model
 * @var View $this
 */
$this->registerCss(<<<CSS
.email-container {
    max-width:50em;
    margin:0 auto;
}
CSS);
?>
<div class="email-container">
    <div class="email-div">
        На вашу заявку от <?= (new DateTime($model->created_at))->format('d.m.Y H:i:s') ?> был получен ответ от ответственного лица:
    </div>
    <div class="email-div">
        <?= Html::encode($model->comment) ?>
    </div>
    <div class="email-div">
        Если у вас остались какие-то вопросы, вы всегда можете повторно оставить заявку на нашем сайте.
    </div>
</div>

