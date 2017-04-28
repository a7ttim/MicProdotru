<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $project_id
 * @property string $name
 * @property int $department_id
 * @property int $pm_id
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property string $type
 * @property string $status
 *
 * @property Department $department
 * @property User $pm
 * @property Task[] $tasks
 * @property WorkingOn[] $workingOns
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'pm_id'], 'required'],
            [['department_id', 'pm_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 5000],
            [['type', 'status'], 'string', 'max' => 20],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'department_id']],
            [['pm_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['pm_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'name' => 'Name',
            'department_id' => 'Department ID',
            'pm_id' => 'Pm ID',
            'description' => 'Description',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['department_id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPm()
    {
        return $this->hasOne(User::className(), ['user_id' => 'pm_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingOns()
    {
        return $this->hasMany(WorkingOn::className(), ['project_id' => 'project_id']);
    }
}
