<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $id string */

$this->title = 'Создать пользователя';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>
