<?php

namespace app\modules\news\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\users\models\UserModel;
use app\modules\news\events\NewsEvent;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $preview
 * @property string $full_text
 * @property integer $status
 * @property integer $createdBy
 * @property integer $created_at
 * @property integer $updated_at
 */
class News extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    private $_oldStatus; // метод $this->getOldAttribute('status'); не работает как надо

    public static function statuses() {
        return [
            self::STATUS_ACTIVE=>'Активен',
            self::STATUS_INACTIVE=>'Не активен',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['preview', 'full_text'], 'string'],
            [['status'], 'integer'],
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
            'preview' => 'Краткий текст',
            'full_text' => 'Полный текст',
            'status' => 'Статус',
            'createdBy' => 'Автор',
            'created_at' => 'Дата создания',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @inheritdoc
     */
     public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->createdBy = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
     }

     /**
      * @inheritdoc
      */
    public function afterFind()
    {
        $this->_oldStatus = $this->status;
        return parent::afterFind();
    }

    /**
     * @inheritdoc
     */
     public function afterSave($insert, $changedAttributes) {
        // Событие: новость опубликована
        if (($this->isNewRecord AND $this->status == self::STATUS_ACTIVE)
            OR ($this->_oldStatus != self::STATUS_ACTIVE AND $this->status == self::STATUS_ACTIVE)
        ) {
            $event = new NewsEvent;
            $event->model = $this;
            Yii::$app->newsEvents->trigger(Yii::$app->newsEvents::EVENT_NEWS_PUBLISHED, $event);
        }
        return parent::afterSave($insert, $changedAttributes);
     }

    /**
     * @inheritdoc
     */
     public function afterDelete() {
        
        return parent::afterDelete();
     }

    /**
     * Getter of property "statusHtml"
     */
    public function getStatusHtml() {
        $statuses = self::statuses();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : $this->status;
    }

    public function getAuthor() {
        return $this->hasOne(UserModel::className(), ['id' => 'createdBy']);
    }
}
