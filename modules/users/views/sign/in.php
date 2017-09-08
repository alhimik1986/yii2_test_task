<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-6">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Вход', [
                'class' => 'btn btn-primary',
                'style'=>'padding-left: 4rem; padding-right: 4rem;',
                'name' => 'login-button',
            ]) ?>

            <?= Html::a('Регистрация', ['up'], [
                'class' => 'btn btn-success',
                'style' => 'float:right; padding-left: 2rem; padding-right: 2rem;',
            ]) ?>
            <div style="clear:both;"></div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
