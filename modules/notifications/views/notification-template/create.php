<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\notifications\models\NotificationTemplate */
/* @var $id string */

$this->title = 'Создать шаблон уведомления';

?>

<div class="notification-template-create">

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>
