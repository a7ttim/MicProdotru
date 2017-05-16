<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $department_id
 * @property string $department_name
 * @property int $parent_department_id
 * @property int $head_id
 *
 * @property Department $parentDepartment
 * @property Department[] $departments
 * @property User $head
 * @property Employment[] $employments
 * @property Project[] $projects
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_department_id', 'head_id'], 'integer'],
            [['head_id'], 'required'],
			[['department_id'], 'safe'],
            [['department_name'], 'string', 'max' => 100],
            [['parent_department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['parent_department_id' => 'department_id']],
            [['head_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['head_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department_id' => 'Department ID',
            'department_name' => 'Отдел',
            'parent_department_id' => 'Parent Department ID',
            'head_id' => 'Head ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentDepartment()
    {
        return $this->hasOne(Department::className(), ['department_id' => 'parent_department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['parent_department_id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHead()
    {
        return $this->hasOne(User::className(), ['user_id' => 'head_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasOne(Employment::className(), ['department_id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['department_id' => 'department_id']);
    }
}
