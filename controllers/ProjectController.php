<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 03.05.2017
 * Time: 13:21
 */

namespace app\controllers;

use app\models\Comment;
use app\models\Project;
use app\models\Task;
use app\models\User;
use Faker\Provider\DateTime;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class ProjectController extends Controller
{
	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if (!\Yii::$app->user->can('pm')) {
				throw new \yii\web\ForbiddenHttpException('Доступ закрыт.');
			}
			return true;
		} else {
			return false;
		}
	}

    public function actionList()
    {
        $model = new Project();
        $projects = Project::find()->where(['pm_id' => Yii::$app->user->identity->user_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $projects->count(),
        ]);

        $projects = $projects->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('list', [
            'model' => $model,
            'projects' => $projects,
            'pagination' => $pagination,
        ]);
    }


    public function actionInfo()    {
        $model = new Task();
        $proj_id=Yii::$app->request->get('project_id');
        $project = Project::findOne(['project_id' => $proj_id]);
        $projectname=$project->name;

        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->where(['and',['project_id' => $proj_id],['status_id'=>[1,2,3]]]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('info', [
            'model' => $model,
            'dataProvider' =>$dataProvider,
            'projectname' => $projectname,
        ]);
    }

    public function actionCreatetask()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['showtask', 'id' => $model->task_id]);
        } else {
            return $this->render('createtask', [
                'model' => $model,
            ]);
        }
    }

    public function actionGantt()
    {
        $project_id = Yii::$app->request->get('project_id');
        $project = Project::findOne(['project_id' => $project_id]);
        $tasks = Task::find()->where(['project_id' => $project_id])->all();
        //$project
        // Перевод данных в формат под диаграмму Гантта
       /* $tasks_ = [];
        foreach ($tasks as $task){
            array_push($tasks_, ["id" => $task->task_id, "text" => $task->name, "start_date" => $task->start_date, "duration" => $task->plan_duration, 'parent' => 999999000 + $project->project_id]);
        }*/
        //$duration = new DateTime($project->start_date);
       // array_unshift($tasks_, ["id" => 999999000 + $project->project_id, "text" => $project->name, "start_date" => $project->start_date, "duration" => 1, "open" => true]);

        //$tasks__['data'] = $tasks_;
        /*$links = [];
        foreach ($tasks as $task){
            array_push($links, ["id" => $task->task_id, "text" => $task->name, "start_date" => $task->start_date, "duration" => 1]);
        }*/

        return $this->render('gantt', [
            'project' => $project,
            'tasks' => $tasks,
            'users' => $project->getUsers()->all(),
        ]);
    }

    protected function findTaskModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionShowtask($id)
    {

        $commentsModel=Comment::find()->where(['task_id' => $id]);

        return $this->render('showtask', [
            'model' => $this->findTaskModel($id),
            'comments'=> $commentsModel,
        ]);
    }


    public function actionUpdatetask($id)
    {
        $model = $this->findTaskModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['info','project_id' =>$model->project_id]);
        } else {
            return $this->render('updatetask', [
                'model' => $model,
            ]);
        }
    }

    public function actionDeletetask($id)
    {
        $model = $this->findTaskModel($id);

        $comment= new Comment();
        $comment->user_id=1;
        $comment->task_id=$model->task_id;
        $comment->date_time=time();
        //$user=User::findOne(Yii::$app->user->identity->user_id);
        //$user_name=
        $comment->text='Задача удалена';
        $comment->save();
        $model->status_id=4;
        $model->save();
        return $this->redirect(['info','project_id' =>$model->project_id]);
    }

    public function actionIndex(){
        return $this->actionList();
    }
}