<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\notifications\models\NotificationTemplate */
/* @var $id string */
?>
<div class="notification-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>

