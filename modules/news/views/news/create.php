<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $id string */

$this->title = 'Создать новость';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>
