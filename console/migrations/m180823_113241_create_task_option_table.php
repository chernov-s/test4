<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_option`.
 */
class m180823_113241_create_task_option_table extends Migration
{
    const TABLE_NAME = "task_option";
    const TABLE_TASK = "task";

    const FOREIGN_KEY_TASK = "FK_" . self::TABLE_NAME . "_" . self::TABLE_TASK;

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
            "task_id" => $this->integer()->notNull(),
            "value" => $this->string(255),
            "is_correct" => $this->boolean(),
        ], $tableOptions);

        $this->addForeignKey(
            self::FOREIGN_KEY_TASK,
            self::TABLE_NAME, "task_id",
            self::TABLE_TASK, "id",
            "CASCADE",
            "CASCADE"
        );

        $optionList = [
            ['task_id' => 1, 'value' => 'норм', 'is_correct' => 1],
            ['task_id' => 2, 'value' => 'Марс', 'is_correct' => 0],
            ['task_id' => 2, 'value' => 'Земля', 'is_correct' => 1],
            ['task_id' => 2, 'value' => 'Меркурий', 'is_correct' => 0],
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
        $this->dropTable(self::TABLE_NAME);
    }
}
