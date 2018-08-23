<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "task_option".
 *
 * @property integer $id
 * @property integer $task_id
 * @property string $value
 * @property integer $is_correct
 *
 * @property Task $task
 */
class TaskOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id', 'is_correct'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'value' => 'Value',
            'is_correct' => 'Is Correct',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
