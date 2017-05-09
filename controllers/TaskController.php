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
        $tasks = Project::find()
            ->joinWith('tasks')
            ->rightJoin('user','user.user_id=task.user_id')
            ->select(['task.task_id','project.name as project','task.name as task','task.description','task.start_date','task.employment_percentage','user.name as user'])
            ->where(['task.user_id' => Yii::$app->user->identity->user_id ,'task.status_id' => 3])
            ->asArray();
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
        $previous_task_id=Task::find()
            ->select(['previous_task_id'])
            ->where(['task_id' =>$_GET['task_id']])
            ->one();
        $previous_task_name=Task::find()
            ->select(['name'])
            ->where(['task_id' =>$previous_task_id])
            ->one();
        $tasks = Project::find()
            ->rightJoin('department','department.department_id=project.department_id')
            ->joinWith('tasks')
            ->rightJoin('user','user.user_id=task.user_id')
            ->select(['task.task_id','project.name as project','task.name as task','task.description','task.start_date','task.employment_percentage','department.department_name as department','user.name as user'])
            ->where(['task.task_id' =>$_GET['task_id']])
            ->asArray()
            ->one();

        return $this->render('soglinfo', [
            'model' => $model,
            'tasks' => $tasks,
            'previous_task_id'=>$previous_task_id,
            'previous_task_name'=>$previous_task_name,
        ]);
    }

    public function actionIndex(){
        return $this->actionSogl();
    }
}