<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user_answer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $task_id
 * @property string $value
 *
 * @property Task $task
 * @property Task $user
 */
class UserAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_answer';
    }

    public function fields() {
        return array_merge(
            parent::fields(),
            [
                'user' => function() {
                    return $this->user;
                },
                'score' => function() {
                    $isCorrect = $this->task->isCorrectAnswer($this->value);
                    if ($this->task->isSimple() && $isCorrect ) {
                        return $this->task->max_ball;
                    }
                    if ($this->task->isMedium() && $isCorrect ) {
                        return $this->task->max_ball;
                    }
                    if ($this->task->isHard() && $isCorrect ) {
                        return $this->task->max_ball;
                    }
                    return 0;
                }
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
