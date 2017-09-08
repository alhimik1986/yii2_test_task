<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(['id' => 'pjax-news-list', 'linkSelector'=>'#pjax-pagination-news-list a']); ?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

        <?php foreach($dataProvider->getModels() as $model): ?>
            <div class="news-item" style="margin-top: 20px;">
                <?php if ( ! Yii::$app->user->isGuest): ?>
                    <?= Html::a('<h3 style="display:inline;">'.$model->title.'</h3>', ['detail', 'id'=>$model->id]); ?>
                <?php else: ?>
                    <h2><?= $model->title?></h2>
                <?php endif; ?>

                <div class="news-info" style="margin-bottom:1rem;">
                    <span class="text-muted">
                        Автор: <?= $model->author->full_name ?>.
                        Создано: <?= Yii::$app->formatter->asDate($model->created_at)?>.
                    </span>
               </div>

                <div class="news-preview">
                    <?=$model->preview?>
                </div>
            </div>
        <?php endforeach; ?>

    <div>
        <div style="float:left">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->getPagination(),
                'options' => [
                    'id' => 'pjax-pagination-news-list',
                    'class' => 'pagination',
                ],
            ]); ?>
        </div>

        <?php if ($dataProvider->getTotalCount() > $dataProvider->getPagination()->getPageSize()): ?>
        <div class="pagination" style="float:left; margin-left: 50px;">
            Число новостей на страницу: 
            <?= Html::dropDownList('per-page', $dataProvider->getPagination()->getPageSize(), [
                '1'=>'1', '3'=>'3', '5'=>'5', '7'=>'7', '10'=>'10', '30'=>'30', '100'=>'100'
            ], [
                'style'=>'height: 30px;',
                'id' => 'news-limit',
            ]); ?>
        </div>
        <?php endif; ?>

        <div style="clear:both"></div>
    </div>

</div>
<?php Pjax::end(); ?>

<?php $this->registerJs('
    jQuery(document).ready(function(){
        var getLimitUrl = function(limit) {
            var queryParams = getUrlVars();
            queryParams["per-page"] = limit;
            var query = jQuery.param(queryParams);
            var baseUrl = window.location.pathname;
            return baseUrl + "?" + query;
        };

        var getUrlVars = function() {
            var vars = {}, hash;
            var hashes = window.location.href.slice(window.location.href.indexOf("?") + 1).split("&");
            for(var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split("=");
                if (hash.length == 1)
                    continue;
                vars[hash[0]] = hash[1];
            }
            return vars;
        }

        jQuery(document).on("change", "#news-limit", function() {
            jQuery.pjax({
                "url": getLimitUrl(jQuery(this).val()),
                "push":true,
                "replace":false,
                "timeout":1000,
                "scrollTo":false,
                "container":"#pjax-news-list"
            });
        });

        jQuery(document).on("click", "#pjax-pagination-news-list a", function() {
            jQuery.pjax({
                "url": jQuery(this).attr("href"),
                "push":true,
                "replace":false,
                "timeout":1000,
                "scrollTo":false,
                "container":"#pjax-news-list"
            });
            return false;
        });
    });
');

