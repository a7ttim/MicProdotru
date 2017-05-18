<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Employment;
use app\models\Department;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\models\Task;

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
            'query' => Task::find()->joinWith('project')->where(['task.user_id' => $id]),
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        return $this->render('info', [
			'usr' => $usr[0],
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex(){
        return $this->actionList();
    }
}