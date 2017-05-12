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
use app\models\Task;
use app\models\Project;
use app\models\User;
use app\models\Department;
use yii\data\Pagination;

class TaskController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can('pe')) {
                throw new \yii\web\ForbiddenHttpException('Доступ закрыт.');
            }
            return true;
        } else {
            return false;
        }
    }

    public function actionSogl()
    {
        $model = new Task();
        $tasks = Task::find()
            ->where(['user_id' => Yii::$app->user->identity->user_id ,'status_id' => 3]);
        $pagination = new Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $tasks->count(),
        ]);

        $tasks = $tasks->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('sogl', [
            'model' => $model,
            'tasks' => $tasks,
            'pagination' => $pagination,
        ]);
    }

    public function actionSoglinfo()    {
        $model = new Task();
        $tasks = Task::findOne($_GET['task_id']);
        $previous_task=Task::findOne($tasks->previous_task_id);

        return $this->render('soglinfo', [
            'model' => $model,
            'tasks' => $tasks,
            'previous_task'=>$previous_task,
            'post' => Yii::$app->request->post('ok'),
        ]);
    }

    public function actionIndex(){
        return $this->actionSogl();
    }
}