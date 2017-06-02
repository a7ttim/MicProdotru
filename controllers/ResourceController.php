<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Employment;
use app\models\Department;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\models\Task;
use app\models\Project;
use app\models\EmploymentSearch;
use app\models\User;

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
        $model = new Task();
        $searchModel = new EmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
			'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel'=> $searchModel,
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
        $cti = 0;
		foreach ($dataProvider->models as $model) {
			if($model->complete_percentage > 0)
				$wl += ($model->employment_percentage * $model->complete_percentage / 100);
			else $wl += $model->employment_percentage;
			$cti++;
		}

        $ctp = Project::find()->joinWith('tasks')->where(['task.user_id'=>$id])->count();
        $cts = Task::find()->where(['and',['status_id'=>1],['user_id'=>$id]])->count();
        $ctcn = Task::find()->where(['and',['status_id'=>6],['user_id'=>$id]])->count();
        $ctcm = Task::find()->where(['and',['status_id'=>3],['user_id'=>$id]])->count();
        return $this->render('info', [
			'usr' => $usr[0],
            'model' => $model,
			'workload' => $wl,
            'count_project'=>$ctp,
			'count_isp' => $cti,
            'count_sogl'=>$cts,
            'count_cansl'=>$ctcn,
            'count_compl'=>$ctcm,
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
		
		$curdt = 365;
		$lstdt = (new \DateTime('now'))->sub(new \DateInterval( "P1Y" ));
		$opt=[];
		
		$post = Yii::$app->request->post();
		if($post != null) {
			if(isset($post['dp_addon_3a']))
				$lstdt = new \DateTime($post['dp_addon_3a']);
			if(isset($post['dp_addon_3b']))
				$curdt = (new \DateTime($post['dp_addon_3b']))->diff($lstdt)->days;
				
			if(isset($post['Project'])){
				if($post['Project']['status'] != -1)
					$proj = $post['Project']['status'];
				$opt[$post['Project']['status']] = ['selected' => true];
			}
		}
		
		$ps = $proj ? ['in', 'task.project_id', $proj] : [];
		$stat= Task::find()
			->joinWith('user')
			->joinWith('project')
			->where(['and', ['and', ['and', 
						['in', 'task.user_id', $users_ar], 
						['>=', 'task.start_date', $lstdt->format('Y-m-d')]
					], ['<=', 'task.plan_duration', $curdt] ],
					$ps, 
				])
			->asArray()->all();
		
		for($i = 0; $i < count($stat); ++$i){
			$j = 0;
			$lbl = explode(' ', $stat[$i]['user']['name'])[0].', '.$stat[$i]['project']['name'];
			for($k = 0; $k < count($tmp); ++$k) {
				if($tmp[$k]['label'] == $lbl) {
					$tmp[$k]['data'][0] += $stat[$i]['plan_duration'];
					$j = 1;
				}
			}
			if(!$j)
				$tmp[] = ['label' => $lbl, 'data' => [$stat[$i]['plan_duration'], 0]];
		}
		
		$dd = Task::find()->select('project.project_id, project.name')->distinct()
		->joinWith('project')->where(['in', 'task.user_id', $users_ar])->asArray()->all();
		
		$dropdown_items[-1] = 'Все проекты';
		for($i = 0; $i < count($dd); ++$i)
			$dropdown_items[$dd[$i]['project_id']] = $dd[$i]['project']['name'] ;
	
		return $this->render('stat', [
            'datasets' => $tmp,
			'curdt' => $curdt,
			'lstdt' => $lstdt,
			'dd_items' => $dropdown_items,
			'model' => new Project(),
			'opt' => $opt
        ]);
	 }

    public function actionIndex(){
        return $this->actionList();
    }
}