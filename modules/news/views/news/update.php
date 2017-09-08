<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $id string */
?>
<div class="news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>
