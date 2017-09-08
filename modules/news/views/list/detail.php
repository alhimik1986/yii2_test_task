<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
?>

<?= Html::a('Назад', ['index'], ['class'=>'btn btn-default']); ?>

<div class="news-detail">
    <h2><?= $model->title?></h2>

    <div class="news-info" style="margin-bottom:1rem;">
        <span class="text-muted">
            Автор: <?= $model->author->full_name ?>.
            Создано: <?= Yii::$app->formatter->asDate($model->created_at)?>.
        </span>
   </div>

    <div class="news-full-text">
        <?=$model->full_text?>
    </div>
</div>