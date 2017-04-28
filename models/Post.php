<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $post_id
 * @property string $post_name
 *
 * @property Employment[] $employments
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'post_name' => 'Post Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployments()
    {
        return $this->hasMany(Employment::className(), ['post_id' => 'post_id']);
    }
}
