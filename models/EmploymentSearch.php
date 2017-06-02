<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employment;

/**
 * EmploymentSearch represents the model behind the search form of `app\models\Employment`.
 */
class EmploymentSearch extends Employment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employment_id', 'user_id', 'department_id', 'post_id'], 'integer'],
            [['begin_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $id = Yii::$app->user->identity->user_id;
        $dep = Department::findOne(['head_id' => $id]);
        $deps = Department::find()
            ->select(['department.department_id'])
            ->where(['parent_department_id' => $dep->department_id])
            ->asArray()->all();
        $deps_ar[] = $dep->department_id;
        for($i = 0; $i < count($deps); ++$i){
            $deps_ar[] = $deps[$i]['department_id'];
        }
        $query = Employment::find()
            ->select(['department.department_id', 'department.department_name',
                'post.post_name', 'post.post_id', 'user.name', 'user.user_id', 'employment_id'])
            ->joinWith('department')
            ->joinWith('user')
            ->joinWith('post')
            ->where(['in', 'department.department_id', $deps_ar])
            ->andWhere(['not', ['employment.user_id' => $id]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 7,
            ],
            'sort' => [
                'defaultOrder' => [
                    'department_id' => SORT_ASC,
                ],
                'attributes' => ['department_id','post_id']
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'employment_id' => $this->employment_id,
            'user.user_id' => $this->user_id,
            'department.department_id' => $this->department_id,
            'post.post_id' => $this->post_id,
            'begin_date' => $this->begin_date,
            'end_date' => $this->end_date,
        ]);

        $query->andFilterWhere(['like', 'user.name', $this->user->name])
            ->andFilterWhere(['like', 'post.post_name', $this->post->post_name])
            ->andFilterWhere(['like', 'department.department_name', $this->department->department_name]);

        return $dataProvider;
    }
}
