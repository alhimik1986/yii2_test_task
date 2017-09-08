<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
?>
<div class="news-view">
    <div>
        <b>#<?= $model->id ?></b>
    </div>
    <div>
        <h4>Автор: <?= $model->author->username?></h4>
    </div>
    <h2><?= $model->title?></h2>
    <br>
    <h4>Краткий текст:</h4>
    <div><?= $model->preview?></div>
    <br>
    <h4>Полный текст текст:</h4>
    <div><?= $model->full_text ?></div>
    <br><br>

    <p>
        <button type="button" class="btn btn-warning" style="float:right; margin-left:10px;"
            onclick="crudActions.close();">
            Отмена
        </button>

        <?php if (Yii::$app->user->can('editNews', ['model'=>$model]) OR Yii::$app->user->can('editOwnNews', ['model'=>$model])): ?>
        <button type="button" class="btn btn-primary" style="float:right;"
            onclick="crudActions.formUpdate('<?=Url::to(['update', 'id'=>$model->id])?>');">
            Редактировать
        </button>
        <?php endif; ?>

        <?php if (Yii::$app->user->can('deleteNews', ['model'=>$model]) OR Yii::$app->user->can('deleteOwnNews', ['model'=>$model])): ?>
        <button type="button" class="btn btn-danger" style="float:left;"
            onclick="crudActions.delete('<?=Url::to(['delete', 'id'=>$model->id])?>');">
            Удалить
        </button>
        <?php endif; ?>
        <div style="clear:both"></div>
    </p>

</div>
