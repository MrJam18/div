<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_request_status}}`.
 */
class m250117_123031_create_user_request_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_request_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
        $this->insert('{{%user_request_status}}', [
            'id' => 1,
            'name' => 'Active',
        ]);
        $this->insert('{{%user_request_status}}', [
            'id' => 2,
            'name' => 'Resolved',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_request_status}}');
    }
}
