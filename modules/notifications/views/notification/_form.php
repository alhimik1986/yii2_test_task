<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\notifications\notifications\Notification;
use app\modules\notifications\models\NotificationTemplate;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */
/* @var $form yii\widgets\ActiveForm */
/* @var $id string */

?>

<div class="notification-form">

    <?php $form = ActiveForm::begin([
        'id'=>'form-'.$id,
        'enableClientValidation' => false,
    ]); ?>

	<?= $form->field($model, 'class_name')->dropDownList(Notification::getClassNames()) ?>

    <?= $form->field($model, 'template_id')->dropDownList(NotificationTemplate::getTemplates()) ?>

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