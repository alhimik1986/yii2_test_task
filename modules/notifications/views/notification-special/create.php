<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\notifications\models\NotificationSpecial */
/* @var $users array */

$this->title = 'Уведомление выбранным пользователям';
//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-special-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        //'users' => isset($users) ? $users : [],
        'users' => $users,
    ]) ?>

</div>
