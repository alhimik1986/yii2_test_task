<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\notifications\models\NotificationTemplate */
/* @var $form yii\widgets\ActiveForm */
/* @var $id string */
?>

<div class="notification-template-form">

    <?php $form = ActiveForm::begin([
        'id'=>'form-'.$id,
        'enableClientValidation' => false,
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <button type="button" class="btn btn-warning" style="float:right; margin-left:10px;"
            onclick="crudActions.close();">
            Отмена
        </button>
        <button type="button" class="btn btn-success" style="float:right;"
            onclick="crudActions.save('<?= Url::to([$model->isNewRecord ? 'create' : 'update', 'id'=>$model->id]) ?>', '#form-<?= $id ?>');">
            Сохранить
        </button>
        <?php if ( ! $model->isNewRecord): ?>
        <button type="button" class="btn btn-danger" style="float:left;"
            onclick="crudActions.delete('<?=Url::to(['delete', 'id'=>$model->id])?>');">
            Удалить
        </button>
        <?php endif; ?>
        <div style="clear:both"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>