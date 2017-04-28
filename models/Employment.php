<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employment".
 *
 * @property int $employment_id
 * @property int $user_id
 * @property int $department_id
 * @property int $post_id
 * @property string $begin_date
 * @property string $end_date
 *
 * @property User $user
 * @property Department $department
 * @property Post $post
 */
class Employment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'department_id', 'post_id'], 'required'],
            [['user_id', 'department_id', 'post_id'], 'integer'],
            [['begin_date', 'end_date'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'department_id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'post_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employment_id' => 'Employment ID',
            'user_id' => 'User ID',
            'department_id' => 'Department ID',
            'post_id' => 'Post ID',
            'begin_date' => 'Begin Date',
            'end_date' => 'End Date',
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
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['department_id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['post_id' => 'post_id']);
    }
}
