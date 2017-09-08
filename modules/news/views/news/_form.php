<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $form yii\widgets\ActiveForm */
/* @var $id string */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
        'id'=>'form-'.$id,
        'enableClientValidation' => false,
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model::statuses()) ?>

    <?= $form->field($model, 'preview')->widget(CKEditor::className(), [
        'preset' => 'custom',
        'clientOptions' => [
            'height' => 120,
            'toolbarGroups' => [
                ['name' => 'clipboard', 'groups' => ['mode', 'undo']],
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                ['name' => 'colors'],
                ['name' => 'links', 'groups' => ['links', 'insert']],
                ['name' => 'others', 'groups' => ['others']],
                ['name' => 'editing', 'groups' => ['tools']],
            ],
            'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe',
            'removePlugins' => 'elementspath',
            'resize_enabled' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'full_text')->widget(CKEditor::className(), [
        'preset' => 'custom',
        'clientOptions' => 
        [
            'height' => 300,
            'toolbarGroups' => [
                ['name' => 'clipboard', 'groups' => ['mode', 'undo']],
                ['name' => 'paragraph', 'groups' => ['templates', 'list', 'indent', 'align']],
                ['name' => 'insert'],
                ['name' => 'editing', 'groups' => ['tools']],
                '/',
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                ['name' => 'colors'],
                ['name' => 'links'],
                ['name' => 'others'],
            ],
            'removeButtons' => 'Smiley,Iframe'
        ],
    ]) ?>

    <div class="form-group">
        <button type="button" class="btn btn-warning" style="float:right; margin-left:10px;"
            onclick="crudActions.close();">
            Отмена
        </button>
        <button type="button" class="btn btn-success" style="float:right;"
            onclick="crudActions.save('<?= Url::to([$model->isNewRecord ? 'create' : 'update', 'id'=>$model->id]) ?>', '#form-<?=$id?>');">
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
