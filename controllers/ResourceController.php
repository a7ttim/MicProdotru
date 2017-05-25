<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Employment;
use app\models\Department;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\models\Task;
use app\models\User;
use app\models\Project;

class ResourceController extends Controller
{
	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if (!\Yii::$app->user->can('dh')) {
				throw new \yii\web\ForbiddenHttpException('Доступ закрыт.');
			}
			return true;
		} else {
			return false;
		}
	}
	
    public function actionList()
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
        $dataProvider = new ActiveDataProvider([
            'query' => Employment::find()
			->select(['department.department_id', 'department.department_name',
			'post.post_name', 'post.post_id', 'user.name', 'user.user_id', 'employment_id'])
			->joinWith('department')
			->joinWith('user')
			->joinWith('post')
			->where(['in', 'department.department_id', $deps_ar])
			->andWhere(['not', ['employment.user_id' => $id]]),
            'pagination' => [
                'pageSize' => 7,
            ],
			'sort' => [
                'defaultOrder' => [
                    'user.name' => SORT_ASC,
                ],
                'attributes' => ['user.name','department.department_name','post.post_name']
            ],
        ]);
		
        return $this->render('list', [
			'model' => new Task(),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInfo()    {
        $model = new Task();
		$id = Yii::$app->request->get('user_id');
		$usr = Employment::find()
			->select(['department.department_name','post.post_name', 'user.name'])
			->joinWith('department')
			->joinWith('user')
			->joinWith('post')
			->where(['employment.user_id' => $id])->asArray()->all();
		
		$dataProvider = new ActiveDataProvider([
            'query' => Task::find()->joinWith('project')
			->where(['and', ['task.user_id' => $id], ['task.status_id' => 2]]),
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
		$wl = 0;
		$cnt = 0;
		foreach ($dataProvider->models as $model) {
			if($model->complete_percentage > 0)
				$wl += ($model->employment_percentage * $model->complete_percentage / 100);
			else $wl += $model->employment_percentage;
			$cnt++;
		}
        return $this->render('info', [
			'usr' => $usr[0],
            'model' => $model,
			'workload' => $wl,
			'count' => $cnt,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGantt()
    {
        $id = Yii::$app->user->identity->user_id;

        $dep = Department::findOne(['head_id' => $id]);
        $deps = Department::find()
            ->select(['department_id'])
            ->where(['parent_department_id' => $dep->department_id])
            ->asArray()->all();
        $deps_ar = array();
        array_push($deps_ar,$dep->department_id,$deps);

        $employments = Employment::find()->where(['in','department_id',$deps_ar])->andWhere(['not', ['user_id' => $id]])->all();
        $tasks = Task::find()->where(['in','user_id', $employments])->all();

        return $this->render('gantt', [
            'tasks' => $tasks,
            'employments' => $employments,
            'links' => Task::find()->where(['in','user_id', $employments])->andWhere(['not',['previous_task_id'=>null]])->all(),
        ]);
    }
	
	 public function actionStat() {
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
        $users = Employment::find()
			->select(['user.user_id'])
			->joinWith('user')
			->where(['in', 'employment.department_id', $deps_ar])
			->andWhere(['not', ['employment.user_id' => $id]])
			->asArray()->all();
		for($i = 0; $i < count($users); ++$i){
			$users_ar[] = $users[$i]['user_id'];
		}
		$stat= Task::find()
			->joinWith('user')
			->joinWith('project')
			->where(['in', 'task.user_id', $users_ar])
			->asArray()->all();
		
		for($i = 0; $i < count($stat); ++$i){
			$j = 0;
			$lbl = $stat[$i]['user']['name'].','.$stat[$i]['project']['name'];
			for($k = 0; $k < count($tmp); ++$k) {
				if($tmp[$k]['label'] == $lbl) {
					$tmp[$k]['data'][0] += round($stat[$i]['fact_duration']/100);
					$j = 1;
				
				}
			}
			if(!$j)
				$tmp[] = ['label' => $lbl, 'data' => [round($stat[$i]['plan_duration']/100)]];
		}	

		return $this->render('stat', [
            'datasets' => $tmp,
        ]);
	 }

    public function actionIndex(){
        return $this->actionList();
    }
}