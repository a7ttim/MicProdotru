<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 03.05.2017
 * Time: 13:21
 */

namespace app\controllers;

use app\models\Project;
use app\models\Task;
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
    public function actionList()
    {
        $model = new Project();
        $projects = Project::find()->where(['status' => 1, 'pm_id' => Yii::$app->user->identity->user_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 1,
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

//    public function actionInfo()    {
//        $model = new Project();
//        $project = Project::findOne(['project_id' => Yii::$app->request->get('project_id')]);
//
//        return $this->render('info', [
//            'model' => $model,
//            'project' => $project,
//        ]);
//    }

    public function actionInfoproject()    {
        $model = new Task();
        //$model = new Task();
        $proj_id=Yii::$app->request->get('project_id');
        $project = Project::findOne(['project_id' => $proj_id]);
        $projectname=$project->name;
        //$projectdesc=$project->description;
        //$tasks = Task::find(['project_id' => $proj_id]);
        $tasks=Task::find()->where(['project_id' => $proj_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->where(['project_id' => $proj_id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('infoproject', [
            'model' => $model,
            //'dataProvider' => $tasks,
            //'dataProvider' => $model,
            'dataProvider' =>$dataProvider,
            'projectname' => $projectname,
            //'projectdesc' => $projectdesc,
        ]);
    }

    public function actionCreatetask()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->task_id]);
        } else {
            return $this->render('createtask', [
                'model' => $model,
            ]);
        }
    }

    public function actionIndex(){
        return $this->actionList();
    }
}