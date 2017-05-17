<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Employment;
use app\models\Department;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\BaseHtml;

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
		$dep = Department::findOne(['head_id' => Yii::$app->user->identity->user_id]);
		$deps = Department::find()
				->select(['department.department_id'])
				->where(['parent_department_id' => $dep->department_id])
				->asArray()->all();
		$deps_ar[] = $dep->department_id;
		for($i = 0; $i < count($deps); ++$i){
			$deps_ar[] = $deps[$i]['department_id'];
		}
		
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => 100,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => Employment::find()
			->joinWith('department')
			->joinWith('user')
			->joinWith('post')
			->where(['in', 'department.department_id', $deps_ar]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
		
		?><script>console.log(<?print_r($dataProvider);?>)</script><?
		
		$mod = new Employment();
		$model = $mod::find()->joinWith('department');
		
        return $this->render('list', [
			'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInfo(){  
    }

    public function actionIndex(){
        return $this->actionList();
    }
}