<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-6">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните указанные поля для регистрации:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'confirm_password')->passwordInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'full_name')->textInput() ?>

        <div class="form-group" style="margin-top: 30px;">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
