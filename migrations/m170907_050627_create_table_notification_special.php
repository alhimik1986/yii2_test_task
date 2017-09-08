<?php

use yii\db\Migration;

class m170907_050627_create_table_notification_special extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification_special', [
            'id' => $this->primaryKey(),
            'notification_type_id' => $this->integer(),
            'title' => $this->string(),
            'body' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('notification_special');
    }
}
