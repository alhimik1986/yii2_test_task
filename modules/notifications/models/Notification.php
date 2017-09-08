<?php

namespace app\modules\notifications\models;

use Yii;
use app\modules\notifications\models\NotificationTemplate;

/**
 * This is the model class for table "notifications".
 *
 * @property integer $id
 * @property string $class_name
 * @property integer $template_id
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id'], 'integer'],
            [['class_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'Класс уведомления',
            'template_id' => 'Шаблон рассылки',
            'template' => 'Шаблон рассылки',
            'title' => 'Вид уведомления',
            'description' => 'Описание',
        ];
    }

    public function getTitle()
    {
        return call_user_func([$this->class_name, 'getTitle']);
    }

    public function getDescription()
    {
        return call_user_func([$this->class_name, 'getDescription']);
    }

    public function getTemplate()
    {
        $template = NotificationTemplate::findOne(['id'=>$this->template_id]);
        return $template ? $template->title : '';
    }
}
