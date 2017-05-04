<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $task_id
 * @property string $name
 * @property int $project_id
 * @property int $user_id
 * @property string $description
 * @property int $parent_task_id
 * @property int $previous_task_id
 * @property string $start_date
 * @property string $plan_end_date
 * @property string $fact_end_date
 * @property int $employment_percentage
 * @property int $status
 * @property int $complete_percentage
 *
 * @property Comment[] $comments
 * @property Project $project
 * @property User $user
 * @property Task $parentTask
 * @property Task[] $tasks
 * @property Task $previousTask
 * @property Task[] $tasks0
 * @property TaskStatus $status0
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'project_id', 'user_id'], 'required'],
            [['project_id', 'user_id', 'parent_task_id', 'previous_task_id', /*'workload',*/'employment_percentage', 'status', 'complete_percentage'], 'integer'],
            [['start_date', 'plan_end_date', 'fact_end_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 5000],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['parent_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['parent_task_id' => 'task_id']],
            [['previous_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['previous_task_id' => 'task_id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::className(), 'targetAttribute' => ['status' => 'task_status_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Задача',
            'name' => 'Название',
            'project_id' => 'Проект',
            'user_id' => 'Исполнитель',
            'description' => 'Описание',
            'parent_task_id' => 'Родительская задача',
            'previous_task_id' => 'Предыдущая задача',
            'start_date' => 'Дата начала',
            'plan_end_date' => 'Плановая дата окончания',
            'fact_end_date' => 'Фактическая дата окончания',
            'employment_percentage' => 'Занятость, %',
            //'workload' => 'Занятость, %',
            'status' => 'Статус',
            'complete_percentage' => 'Завершенность, %',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['task_id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['project_id' => 'project_id']);
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
    public function getParentTask()
    {
        return $this->hasOne(Task::className(), ['task_id' => 'parent_task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['parent_task_id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreviousTask()
    {
        return $this->hasOne(Task::className(), ['task_id' => 'previous_task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['previous_task_id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(TaskStatus::className(), ['task_status_id' => 'status']);
    }
}
