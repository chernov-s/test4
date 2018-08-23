<?php

use api\modules\v1\models\ScoreType;
use api\modules\v1\models\TaskType;
use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m180803_063353_create_task_table extends Migration
{
    const TABLE_NAME = "task";

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
            "name" => $this->string(255),
            "type" => $this->smallInteger()->defaultValue(TaskType::INPUT),
            "max_ball" => $this->integer()->defaultValue(10),
            "score_type" => $this->integer()->defaultValue(ScoreType::SIMPLE),
            "created_at" => $this->integer(),
            "updated_at" => $this->integer(),
        ], $tableOptions);

        $this->insertTestData();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }

    public function insertTestData() {

        $taskList = [
            [
                'name' => 'Как дела',
                'type' =>  TaskType::INPUT
            ],
            [
                'name' => 'С какой планеты?',
                'type' =>  TaskType::SELECT,
                'score_type' => ScoreType::HARD
            ],
        ];

        foreach ($taskList as $task) {
            $this->insert(self::TABLE_NAME, $task);
        }
    }
}
