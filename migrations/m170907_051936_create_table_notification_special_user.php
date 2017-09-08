<?php

use yii\db\Migration;

class m170907_051936_create_table_notification_special_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification_special_user', [
            'id' => $this->primaryKey(),
            'notification_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('notification_special_user');
    }
}
