<?php

use yii\db\Migration;

class m170901_151616_create_table_news extends Migration
{
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'preview' => $this->text(),
            'full_text' => $this->text(),
            'status' => $this->integer()->notNull(),
            'createdBy' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
       $this->dropTable('news');
    }
}
