<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170103_025617_create_user_table extends Migration
{
    /**
     * @inheritdoc
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'encrypted_password' => $this->string(60)->notNull(),
            'access_token' => $this->string()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->insert('user', [
            'username' => 'Vasya',
            'email' => 'super_vasya@testmail.ru',
            'encrypted_password' => Yii::$app->security->generatePasswordHash('123123'),
            'access_token' => Yii::$app->security->generateRandomString(),
            'updated_at' => time(),
            'created_at' => time(),
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
