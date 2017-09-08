<?php

namespace app\modules\notifications\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "newsletter_template".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 */
class NotificationTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'body' => 'Текст шаблона',
        ];
    }

    /**
     * Список шаблонов для выпадающего списка
     */
    public static function getTemplates()
    {
        $models = NotificationTemplate::find()->all();
        return ArrayHelper::map($models, 'id', 'title');
    }
}
