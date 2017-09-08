<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170901_151156_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email' => $this->string()->notNull()->unique(),
            'email_confirm_token' => $this->string(),
            'auth_key' => $this->string(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'auth_at' => $this->integer(),

            'full_name' => $this->string(),
        ]);

        $this->insert('user', [
            'username' => 'admin',
            'password_hash' => '$2y$13$.YosvI7JqkuX1qY/mtpWl.u.bKJeZ2a3rlAtv/lkxE5q6oofxbL8W',
            'email' => 'admin@admin.ru',
            'status' => 10,
            'created_at' => time(),
            'full_name' => 'Admin',
        ]);

        $this->insert('user', [
            'username' => 'manager',
            'password_hash' => '$2y$13$rkvq3KCZeUc/xTg0ZRiUm.AQUpT1iRR1kymitpuZJbOqh4xFECkzi',
            'email' => 'manager@manager.ru',
            'status' => 10,
            'created_at' => time(),
            'full_name' => 'Manager',
        ]);

        $this->insert('user', [
            'username' => 'user',
            'password_hash' => '$2y$13$33NbEGdAz5HmJtyBAqZWiO1Ic8VstQH7riVXqduliPg/n.TAHl5Qa',
            'email' => 'user@user.ru',
            'status' => 10,
            'created_at' => time(),
            'full_name' => 'User',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
