<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 03.05.2017
 * Time: 13:21
 */

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
        $model = new Employment();
		$dep = Department::findOne(['head_id' => Yii::$app->user->identity->user_id]);
        $resources = Employment::find()->where(['department_id' => $dep->department_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $resources->count(),
        ]);

        $resources = $resources->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('list', [
            'model' => $model,
            'resources' => $resources,
            'pagination' => $pagination,
        ]);
    }

    public function actionInfo()    {
        
    }

    public function actionIndex(){
        return $this->actionList();
    }
}