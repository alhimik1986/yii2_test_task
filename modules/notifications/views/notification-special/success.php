<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\notifications\models\NotificationSpecial */

$this->title = 'Уведомление успешно отправлено';
//$this->params['breadcrumbs'][] = ['label' => 'Уведомление успешно отправлено', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-special-view">

    <h1>Уведомление успешно отправлено</h1>

    <?php /*echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'body',
        ],
    ])*/ ?>

    <b>Текст уведомления: </b> <span><?= Html::encode($model->body) ?></span>

</div>
