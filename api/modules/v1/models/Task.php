<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $max_ball
 * @property integer $score_type
 * @property integer $created_at
 * @property integer $updated_at
 * @property TaskOption[] $options
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }


    public function extraFields()
    {
        return ['options'];
    }

    /**
     * @inheritdoc
     */
    public function fields() {
        return array_merge(
            parent::fields(),
            [
                'options' => function() {
                    return $this->options;
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
            [['type', 'created_at', 'updated_at', 'score_type', 'max_ball'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'max_ball' => 'Max ball',
            'score_type' => 'Score type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(TaskOption::className(), ['task_id' => 'id']);
    }

    /**
     * Проверка корректности ответа на вопрос
     * @param $value
     * @return bool
     */
    public function isCorrectAnswer($value) {
        foreach ($this->options as $option) {
            if ($option->is_correct && $option->value == $value) {
                return true;
            }
        }
        return false;
    }

    public function isInputType() {
        return $this->type === TaskType::INPUT;
    }

    public function isSelectType() {
        return $this->type === TaskType::SELECT;
    }

    public function isSimple() {
        return $this->score_type === ScoreType::SIMPLE;
    }

    public function isMedium() {
        return $this->score_type === ScoreType::MEDIUM;
    }

    public function isHard() {
        return $this->score_type === ScoreType::HARD;
    }
}
