<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NotificationTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id string */

$this->title = 'Настройка шаблонов рассылок';
$this->params['breadcrumbs'][] = $this->title;
app\modules\users\assets\CrudActionsAsset::register(Yii::$app->view);
?>

<div id="<?=$id?>-errors"></div>

<div class="notification-template-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button type="button" class="btn btn-success"
            onclick="crudActions.formCreate('<?= Url::to(['create'])?>', 'Создать')">
            Создать
        </button>
    </p>
    <?php Pjax::begin(['id' => 'pjax-grid-view-'.$id]); ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'body',
             [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:105px;'],
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        $url = Url::to(['view', 'id'=>$model->id]);
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', [
                            'value'=>$url, 'class' => 'btn btn-success btn-xs custom_button',
                            'onclick'=>"crudActions.formView('".$url."');"
                        ]);
                    },
                    'update'=>function ($url, $model) {
                        if ( ! Yii::$app->user->can('editNews', ['model'=>$model]) AND ! Yii::$app->user->can('editOwnNews', ['model'=>$model]))
                            return '';
                        $url = Url::to(['update', 'id'=>$model->id]);
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', [
                            'value'=>$url, 'class' => 'btn btn-primary btn-xs custom_button',
                            'onclick'=>"crudActions.formUpdate('".$url."');"
                        ]);
                    },
                    'delete'=>function ($url, $model) {
                        if ( ! Yii::$app->user->can('deleteNews', ['model'=>$model]) AND ! Yii::$app->user->can('deleteOwnNews', ['model'=>$model]))
                            return '';
                        $url = Url::to(['delete', 'id'=>$model->id]);
                        return Html::button('<span class="glyphicon glyphicon-trash"></span>', [
                            'value'=>$url, 'class' => 'btn btn-danger btn-xs custom_button',
                            'onclick'=>"crudActions.delete('".$url."');"
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$this->registerJs('
    var crudActions = new CrudActions({
        id: "'.$id.'-actions",
        errorSelector: "#'.$id.'-errors",
        modalSelector: "#modal-'.$id.'",
        modalContentSelector: "#modal-'.$id.' .modal-body-content",
        modalHeaderTitleSelector: "#modal-'.$id.' .modal-header-title",
        pjaxSelector: "#pjax-grid-view-'.$id.'"
    });
    
', \yii\web\View::POS_END);


yii\bootstrap\Modal::begin([
    'id' => 'modal-'.$id,
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => true],
    'header' => '<div class="modal-header-title" style="float:left; width: 98%;"></div>',
]);
echo "<div class=\"modal-body-content\"></div>";
yii\bootstrap\Modal::end();
