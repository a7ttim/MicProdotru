<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $comment_id
 * @property string $text
 * @property int $user_id
 * @property int $task_id
 * @property string $date_time
 *
 * @property User $user
 * @property Task $task
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id', 'text'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            [['date_time'], 'safe'],
            [['text'], 'string', 'max' => 5000],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'task_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'ID комментария',
            'text' => 'Текст комментария',
            'user_id' => 'Автор',
            'task_id' => 'Задача',
            'date_time' => 'Дата, время',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['task_id' => 'task_id']);
    }
}
