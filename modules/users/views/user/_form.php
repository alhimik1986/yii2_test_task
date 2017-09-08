<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $id string */

?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id'=>'form-'.$id,
        'enableClientValidation' => false,
    ]); ?>

	<?= $form->field($model, 'username')->textInput() ?>

	<?= $form->field($model, 'password')->textInput() ?>

	<?= $form->field($model, 'email')->textInput() ?>

	<?= $form->field($model, 'full_name')->textInput() ?>
	
    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE=>'Активен', $model::STATUS_UNCONFIRMED=>'Не подтвержден', $model::STATUS_DELETED=>'Удален']) ?>

    <?= $form->field($model, 'roles')->checkboxList(ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'), ['separator'=>'<br>']) ?>

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
