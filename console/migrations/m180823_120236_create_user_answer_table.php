<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_answer`.
 */
class m180823_120236_create_user_answer_table extends Migration
{
    const TABLE_NAME = "user_answer";
    const TABLE_TASK = "task";
    const TABLE_USER = "user";

    const FOREIGN_KEY_TASK = "FK_" . self::TABLE_NAME . "_" . self::TABLE_TASK;
    const FOREIGN_KEY_USER = "FK_" . self::TABLE_NAME . "_" . self::TABLE_USER;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            "user_id" => $this->integer()->notNull(),
            "task_id" => $this->integer()->notNull(),
            "value" => $this->string(255),
        ], $tableOptions);

        $this->addForeignKey(
            self::FOREIGN_KEY_TASK,
            self::TABLE_NAME, "task_id",
            self::TABLE_TASK, "id",
            "CASCADE",
            "CASCADE"
        );

        $this->addForeignKey(
            self::FOREIGN_KEY_USER,
            self::TABLE_NAME, "user_id",
            self::TABLE_TASK, "id",
            "CASCADE",
            "CASCADE"
        );

        $optionList = [
            ['user_id' => 1,'task_id' => 1, 'value' => 'норм'],
            ['user_id' => 1,'task_id' => 2, 'value' => 'Марс'],
            ['user_id' => 1,'task_id' => 2, 'value' => 'Земля'],
        ];
        foreach ($optionList as $item) {
            $this->insert(self::TABLE_NAME, $item);
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(self::FOREIGN_KEY_TASK, self::TABLE_NAME);
        $this->dropForeignKey(self::FOREIGN_KEY_USER, self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
