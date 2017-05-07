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
 * @property int $plan_duration
 * @property int $fact_duration
 * @property int $employment_percentage
 * @property int $status_id
 * @property int $complete_percentage
 *
 * @property Comment[] $comments
 * @property Project $project
 * @property User $user
 * @property Task $parentTask
 * @property Task[] $tasks
 * @property Task $previousTask
 * @property Task[] $tasks0
 * @property Status $status
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
            [['project_id', 'user_id', 'parent_task_id', 'previous_task_id', 'plan_duration', 'fact_duration', 'employment_percentage', 'status_id', 'complete_percentage'], 'integer'],
            [['start_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 5000],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['parent_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['parent_task_id' => 'task_id']],
            [['previous_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['previous_task_id' => 'task_id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'status_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'name' => 'Name',
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'description' => 'Description',
            'parent_task_id' => 'Parent Task ID',
            'previous_task_id' => 'Previous Task ID',
            'start_date' => 'Start Date',
            'plan_duration' => 'Plan Duration',
            'fact_duration' => 'Fact Duration',
            'employment_percentage' => 'Employment Percentage',
            'status_id' => 'Status ID',
            'complete_percentage' => 'Complete Percentage',
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
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['status_id' => 'status_id']);
    }
}
