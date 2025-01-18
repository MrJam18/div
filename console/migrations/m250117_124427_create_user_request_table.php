<?php

use yii\db\Migration;

class m250117_124427_create_user_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%user_request}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'user_request_status_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'comment' => $this->text()->null(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'responsible_user_id' => $this->integer()->null(),
        ]);
        $this->addForeignKey('FK_user_request_to_user_request_status', 'user_request', 'user_request_status_id', 'user_request_status', 'id');
        $this->addForeignKey('FK_user_request_to_responsible_user_id', 'user_request', 'responsible_user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%user_request}}');
    }
}
