<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\notifications\models\NotificationSpecial;

/* @var $this yii\web\View */
/* @var $model app\modules\notifications\models\NotificationSpecial */
/* @var $users array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-special-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'notification_type_id')->dropDownList(NotificationSpecial::getNotificationTypes()) ?>

    <?php // echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <!-- Выбор пользователей -->
    <br>
    <label for="">Пользователи:</label>
    <br><br>
    <div>
        <div>
            <label>
                <?= Html::checkbox('user_all', false, [
                    'onclick'=> "jQuery(this).closest('label').parent().next().find(':checkbox').prop('checked', jQuery(this).prop('checked'))",
                ]); ?>
                Выбрать всех
            </label>
            <br><br>
        </div>
        
        <div style="margin-left: 20px;">
            <?php $index = 0; ?>
            <?php foreach($users as $roleName=>$userGroup): ?>
                <label>
                    <?= Html::checkbox('user_group_'.(++$index), false, [
                        'onclick'=> "jQuery(this).closest('label').next().find('.user-checkbox').prop('checked', jQuery(this).prop('checked'))",
                    ]); ?>
                    <?= $roleName ?>
                </label>
                <div>
                    <?php foreach($userGroup as $user_id=>$user): ?>
                        <div style="margin-left: 20px;">
                            <label style="font-weight: normal;">
                                <?= Html::checkbox('users['.$user_id.']', false, ['class'=>'user-checkbox']); ?>
                                <?= $user['full_name'] ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="has-error">
        <div class="help-block">
            <?= Html::error($model, 'users'); ?>
        </div>
    </div>

    <br><br>
    <!-- Конец выбор пользователей -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Отправить' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
