<?php

use yii\db\Migration;

class m170906_083139_create_table_notification extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'class_name' => $this->string(),
            'template_id' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('notification');
    }
}
