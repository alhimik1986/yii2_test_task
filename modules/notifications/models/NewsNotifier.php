<?php

namespace app\modules\notifications\models;

use Yii;
use app\modules\news\models\News;

/**
 * Вспомогательная модель (таблица) для подсчета количества неуведомленных новостей.
 *
 * @property integer $user_id
 * @property integer $last_news_id
 */
class NewsNotifier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_notifier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_news_id'], 'required'],
            [['last_news_id'], 'integer'],
        ];
    }

    /**
     * Получает список всех последних новостей, которые появились с момента 
     * последнего просмотра ленты новостей
     */
    public static function getLastNews()
    {
        if (Yii::$app->user->isGuest) {
            return [];
        }
        $user_id = Yii::$app->user->identity->id;
        $last_news = self::findOne(['user_id'=>$user_id]);
        $last_news_id = $last_news ? $last_news->last_news_id : 0;
        $last_news = News::find()
            ->andWhere(['status'=>News::STATUS_ACTIVE])
            ->andWhere(['>', 'id', $last_news_id])
            ->all();

        return $last_news;
    }

    /**
     * Запомнить последнюю новость
     * @return boolean Успешность операции
     */
    public static function setLastNews()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $last_news = News::find()
            ->andWhere(['status'=>News::STATUS_ACTIVE])
            ->orderBy(['id'=>SORT_DESC])
            ->one();
        $last_news_id = $last_news ? $last_news->id : 0;
        $user_id = Yii::$app->user->identity->id;

        $a = new static();
        $model = self::findOne(['user_id'=>$user_id]);
        $model = $model ? $model : new static();
        $model->user_id = $user_id;
        $model->last_news_id = $last_news_id;
        return ($model->validate() AND $model->save());
    }
}
