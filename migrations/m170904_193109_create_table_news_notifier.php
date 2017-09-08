<?php

use yii\db\Migration;

class m170904_193109_create_table_news_notifier extends Migration
{
    public function safeUp()
    {
        $this->createTable('news_notifier', [
            'user_id' => $this->primaryKey(),
            'last_news_id' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('news_notifier');
    }
}
