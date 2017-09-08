<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        //'brandLabel' => 'Главная',
        //'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $userRoles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            //['label' => 'Главная', 'url' => ['/site/index']],
            ['label' => 'Список новостей', 'url' => ['/news/list/index']],
            ['label' => 'Пользователи', 'url' => ['/users/user/index'], 'visible'=>isset($userRoles['admin'])],
            ['label' => 'Новости', 'url' => ['/news/news/index'], 'visible'=>(isset($userRoles['admin']) OR isset($userRoles['manager']))],
            ['label' => 'Рассылка партнерам', 'url' => ['/notifications/notification-special/create'], 'visible'=>isset($userRoles['admin'])],
            ['label' => 'Настройка уведомлений о новостях', 'url' => ['/notifications/notification/index'], 'visible'=>isset($userRoles['admin'])],
            ['label' => 'Шаблоны рассылок', 'url' => ['/notifications/notification-template/index'], 'visible'=>isset($userRoles['admin'])],
            Yii::$app->user->isGuest ? (
                ['label' => 'Вход', 'url' => ['/users/sign/in']]
            ) : (
                '<li>'
                . Html::beginForm(['/users/sign/out'], 'post')
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <!-- Flash messages -->
        <?php
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            $key = ($key == 'error') ? 'danger' : $key;
            if (is_array($message)) {
                foreach($message as $msg) {
                    echo Alert::widget([
                        'options' => ['class' => 'alert-'.$key],
                        'body' => $msg,
                    ]);
                }
            } else {
                echo Alert::widget([
                    'options' => ['class' => 'alert-'.$key],
                    'body' => $message,
                ]);
            }
        }
        ?>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
