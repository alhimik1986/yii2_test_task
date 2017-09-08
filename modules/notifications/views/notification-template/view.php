<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NotificationTemplate */
?>
<div class="notification-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'body',
        ],
    ]) ?>

    <p>
        <button type="button" class="btn btn-warning" style="float:right; margin-left:10px;"
            onclick="crudActions.close();">
            Отмена
        </button>
        <button type="button" class="btn btn-primary" style="float:right;"
            onclick="crudActions.formUpdate('<?=Url::to(['update', 'id'=>$model->id])?>');">
            Редактировать
        </button>
        <button type="button" class="btn btn-danger" style="float:left;"
            onclick="crudActions.delete('<?=Url::to(['delete', 'id'=>$model->id])?>');">
            Удалить
        </button>
        <div style="clear:both"></div>
    </p>

</div>
