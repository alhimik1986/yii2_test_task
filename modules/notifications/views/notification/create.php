<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Notification */
/* @var $id string */

$this->title = 'Создать уведомление';

?>

<div class="notification-create">

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>