<?php

use yii\db\Migration;

/**
 * Class m250119_194325_create_test_responsible_user
 */
class m250119_194325_create_test_responsible_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $now = (new DateTime())->format('Y-m-d H:i:s');
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'auth_key_expired_at' => (new \DateTime())->modify('+6 months')->format('Y-m-d H:i:s'),
            'email' => 'admin@admin.com',
            'type' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo 'migration m250119_194325_create_test_responsible_user can`t be reverted.\n";';
        return false;
    }
}
