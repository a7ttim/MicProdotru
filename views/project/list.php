<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 01.05.2017
 * Time: 18:12
 */


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
/* @var $model app\models\project */


use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Project;
use app\models\Task;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\User;

$this->title = \app\models\ProjectStatus::findOne(['status_id' => $status_id])->status_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>
    <?= $this->title ?>
</h1>
<p>
    <?= Html::a('+ Новый проект', ['createproject'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        [
            'attribute' => 'pm_id',
            'value' => 'pm.name',
            'filter'=>ArrayHelper::map(User::find()
                ->joinWith('projects')
                ->where(['project.status_id' => Yii::$app->request->get('status_id')])
                ->asArray()
                ->all(),
                'user_id', 'name'),
        ],
        [
            'attribute' => 'description',
            'format' => 'text',
            'value' => function ($model){
                return StringHelper::truncate($model->description, 50);
            }
        ],
        [
            'attribute' => '',
            'value' => function (Project $project) {
                return Html::a('<span class="fa fa-search"></span> Подробнее', Url::to(['info', 'project_id' => $project->project_id]), [
                    'title' => Yii::t('app', 'Подробнее'),
                    'class' =>'btn btn-info btn-xs',
                ]);
            },
            'format' => 'raw',
            'contentOptions' => ['style' => 'width:30px;'],
        ],
        [
            'attribute' => '',
            'value' => function (Project $project) {
                if($project->getTasks()->where(['not in', 'status_id', [1,4,6]])->count()>0) {return Html::a('<span class="fa fa-search"></span> Визуализация', Url::to(['gantt', 'project_id' => $project->project_id]), [
                    'title' => Yii::t('app', 'Подробнее'),
                    'class' =>'btn btn-primary btn-xs',
                ]);}
                else return '';
            },
            'format' => 'raw',
            'contentOptions' => ['style' => 'width:30px;'],
        ],

    ],
]); ?>

<?/*= LinkPager::widget(['pagination' => $pagination]) */?>
