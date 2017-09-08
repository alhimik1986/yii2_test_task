<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\Notification */
/* @var $id string */
?>
<div class="notification-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>
