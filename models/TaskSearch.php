<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;
use app\models\Project;

/**
 * TaskSearch represents the model behind the search form of `app\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'project_id', 'user_id', 'parent_task_id', 'previous_task_id', 'plan_duration', 'fact_duration', 'employment_percentage', 'status_id', 'complete_percentage'], 'integer'],
            [['name', 'description', 'start_date'], 'safe'],
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
        if(Yii::$app->request->resolve()[0]=='task/sogl') $status_id = 1;
        if(Yii::$app->request->resolve()[0]=='task/isp') $status_id = 2;
        if(Yii::$app->request->resolve()[0]=='task/compl') $status_id = 3;
        $query = Task::find()->where(['user_id' => Yii::$app->user->identity->user_id ,'status_id' => $status_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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
            'task_id' => $this->task_id,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'parent_task_id' => $this->parent_task_id,
            'previous_task_id' => $this->previous_task_id,
            'start_date' => $this->start_date,
            'plan_duration' => $this->plan_duration,
            'fact_duration' => $this->fact_duration,
            'employment_percentage' => $this->employment_percentage,
            'status_id' => $this->status_id,
            'complete_percentage' => $this->complete_percentage,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public function projectsearch($params)
    {
        $query = Project::findOne(['project_id' => Yii::$app->request->get('project_id')])->getTasks()->with('user');
//        $query = Project::find()
//            ->select(['task.name', 'task.description', 'task.employment_percentage', 'task.complete_percentage'])
//            ->joinWith('tasks')
//            ->joinWith('users')
//            ->where(['project.project_id' => Yii::$app->request->get('project_id')]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ],
                'attributes' => ['name','description', 'employment_percentage', 'complete_percentage', 'status_id']
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
            'task_id' => $this->task_id,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'parent_task_id' => $this->parent_task_id,
            'previous_task_id' => $this->previous_task_id,
            'start_date' => $this->start_date,
            'plan_duration' => $this->plan_duration,
            'fact_duration' => $this->fact_duration,
            'employment_percentage' => $this->employment_percentage,
            'status_id' => $this->status_id,
            'complete_percentage' => $this->complete_percentage,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public function ressearch($params)
    {
        $query = Task::find()->joinWith('project')
            ->where(['and', ['task.user_id' => Yii::$app->request->get('user_id')], ['task.status_id' => 2]]);
//        $query = Project::find()
//            ->select(['task.name', 'task.description', 'task.employment_percentage', 'task.complete_percentage'])
//            ->joinWith('tasks')
//            ->joinWith('users')
//            ->where(['project.project_id' => Yii::$app->request->get('project_id')]);


        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ],
                'attributes' => ['name','start_date','plan_duration', 'employment_percentage', 'complete_percentage']
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
            'task_id' => $this->task_id,
            'project.project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'parent_task_id' => $this->parent_task_id,
            'previous_task_id' => $this->previous_task_id,
            'start_date' => $this->start_date,
            'plan_duration' => $this->plan_duration,
            'fact_duration' => $this->fact_duration,
            'employment_percentage' => $this->employment_percentage,
            'status_id' => $this->status_id,
            'complete_percentage' => $this->complete_percentage,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
