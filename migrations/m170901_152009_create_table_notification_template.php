<?php

use yii\db\Migration;

class m170901_152009_create_table_notification_template extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification_template', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'body' => $this->text()->notNull(),
        ]);

        $this->insert('notification_template', [
            'title' => 'E-mail шаблон',
            'body' => 'Уважаемый, {username}! На нашем сайте {site_url} добавлена новая новость: <a href="{new-link}">{new-title}</a> <br> {new-description}',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('notification_template');
    }
}
