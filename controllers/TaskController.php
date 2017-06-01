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
use app\models\TaskSearch;
use app\models\Comment;
use app\models\Project;
use app\models\User;
use app\models\Department;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\i18n\Formatter;

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
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('sogl', [
            'searchModel'=> $searchModel,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSoglinfo($task_id)    {
        $model = new Task();
        $modelcom = new Comment();
        $tasks = Task::findOne($task_id);
        $previous_task=Task::findOne($tasks->previous_task_id);
        $comments = Comment::find()->where(['task_id'=>$task_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 4,
            'totalCount' => $comments->count(),
        ]);

        $comments = $comments->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if (Yii::$app->request->post('ok')) {
            $tasks->status_id=2;
            $tasks->save();
            return $this->goBack();
        }

        if (Yii::$app->request->post('cancel')) {
            $tasks->status_id=6;
            $tasks->save();
            $modelcom->text=Yii::$app->request->post('mtext');
            $modelcom->user_id=Yii::$app->user->identity->user_id;
            $modelcom->task_id=$tasks->task_id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->goBack();
        }

        if (Yii::$app->request->post('text')) {
            $modelcom->text=Yii::$app->request->post('text');
            $modelcom->user_id=Yii::$app->user->identity->user_id;
            $modelcom->task_id=$tasks->task_id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->refresh();
        }

        $date = date_create($tasks->start_date);
        date_add($date, date_interval_create_from_date_string($tasks->plan_duration.' days'));
        $plan_end_date = date_format($date, 'd.m.Y');

        return $this->render('soglinfo', [
            'model' => $model,
            'modelcom' => $modelcom,
            'tasks' => $tasks,
            'previous_task'=>$previous_task,
            'comments'=>$comments,
            'pagination' => $pagination,
            'plan_end_date'=>$plan_end_date
        ]);
    }

    public function actionIsp()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Task();

        return $this->render('isp', [
            'searchModel' => $searchModel,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIspinfo($task_id)    {
        $model = new Task();
        $modelcom = new Comment();
        $tasks = Task::findOne($task_id);
        $previous_task=Task::findOne($tasks->previous_task_id);
        $comments = Comment::find()->where(['task_id'=>$task_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 4,
            'totalCount' => $comments->count(),
        ]);

        $comments = $comments->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $start_date = date_create($tasks->start_date);
        $end_date = date_create(date('Y-m-d H:i:s'));
        $time = date_diff($start_date, $end_date)->format('%a');

        if (Yii::$app->request->post('complete')) {
            $tasks->status_id=3;
            $tasks->fact_duration=$time;
            $tasks->save();
            return $this->goBack();
        }

        if (Yii::$app->request->post('cp')) {
            $tasks->complete_percentage=Yii::$app->request->post('cp');
            $tasks->save();
            return $this->refresh();
        }

        if (Yii::$app->request->post('text')) {
            $modelcom->text=Yii::$app->request->post('text');
            $modelcom->user_id=Yii::$app->user->identity->user_id;
            $modelcom->task_id=$tasks->task_id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->refresh();
        }

        $date = date_create($tasks->start_date);
        date_add($date, date_interval_create_from_date_string($tasks->plan_duration.' days'));
        $plan_end_date = date_format($date, 'd.m.Y');

        return $this->render('ispinfo', [
            'model' => $model,
            'modelcom' => $modelcom,
            'tasks' => $tasks,
            'previous_task'=>$previous_task,
            'comments'=>$comments,
            'pagination' => $pagination,
            'time'=>$time,
            'plan_end_date'=>$plan_end_date
        ]);
    }

    public function actionCompl()
    {
        $model = new Task();
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('compl', [
            'searchModel'=> $searchModel,
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionComplinfo($task_id)    {
        $model = new Task();
        $modelcom = new Comment();
        $tasks = Task::findOne($task_id);
        $previous_task=Task::findOne($tasks->previous_task_id);
        $comments = Comment::find()->where(['task_id'=>$task_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 4,
            'totalCount' => $comments->count(),
        ]);

        $comments = $comments->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if (Yii::$app->request->post('text')) {
            $modelcom->text=Yii::$app->request->post('text');
            $modelcom->user_id=Yii::$app->user->identity->user_id;
            $modelcom->task_id=$tasks->task_id;
            $modelcom->date_time=date('Y-m-d H:i:s');
            $modelcom->save();
            return $this->refresh();
        }
        
        $date = date_create($tasks->start_date);
        date_add($date, date_interval_create_from_date_string($tasks->fact_duration.' days'));
        $fact_end_date = date_format($date, 'd.m.Y');

        return $this->render('complinfo', [
            'model' => $model,
            'modelcom' => $modelcom,
            'tasks' => $tasks,
            'previous_task'=>$previous_task,
            'comments'=>$comments,
            'pagination' => $pagination,
            'fact_end_date'=>$fact_end_date,
        ]);
    }

    public function actionStat()
    {
        $model = new Task();
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->where(['user_id' => Yii::$app->user->identity->user_id]),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        return $this->render('stat', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex(){
        return $this->actionSogl();
    }
}