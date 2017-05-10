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
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use app\models\Project;
use app\models\Task;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = \app\models\Status::findOne(['status_id' => $status_id])->status_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<!--
<table class="table table-responsive table-bordered">
    <tbody>
    <tr>
        <th class="text-center">
            #
        </th>
        <th>
            Имя
        </th>
        <th>
            Описание
        </th>
        <th class="text-center">
            Ссылка
        </th>
        <th class="text-center">
            Диаграмма
        </th>
    </tr>
    <?/*
    foreach ($projects as $project){
        */?>
        <tr>
            <td class="text-center">
                <?/*= $project->project_id; */?>
            </td>
            <td>
                <?/*= $project->name; */?>
            </td>
            <td>
                <?/*= $project->description; */?>
            </td>
            <td>
                <?/* echo Html::a(
                        'Подробнее',
                        Url::to(['project/info', 'project_id' => $project->project_id]),
                        ['class' => 'btn-link center-block']
                )
                */?>
            </td>
            <td>
                <?/* echo Html::a(
                        'Подробнее',
                        Url::to(['project/gantt', 'project_id' => $project->project_id]),
                        ['class' => 'btn-link center-block']
                )
                */?>
            </td>
        </tr>
        <?/*
    }
    */?>
    </tbody>
</table>-->

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'task_id',
        'name',
        //'project_id',
//        [
//            'attribute' => 'project_id',
//            'value' => 'project.name',
//        ],
        'pm_id',
/*        [
            'attribute' => 'pm_id',
            'value' => 'user.name',
        ],*/
        'description',
        // 'parent_task_id',
        // 'previous_task_id',
        // 'start_date',
        // 'plan_end_date',
        // 'fact_end_date',
        // 'status_id',
//            [
//                'attribute' => 'status',
//                'value' => 'status.status_name',
//            ],
//        [
//            'attribute' => 'status',
//            'filter' => array("1"=>"На согласовании","2"=>"На исполнении","3"=>"Завершена","4"=>"Удалена","5"=>"На исполнении"),
//        ],

        [
            'attribute' => 'Информация',
            'value' => function (Project $project) {
                return Html::a('Подробнее', Url::to(['info', 'project_id' => $project->project_id]));
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'Визуализация',
            'value' => function (Project $project) {
                return Html::a('Подробнее', Url::to(['gantt', 'project_id' => $project->project_id]));
            },
            'format' => 'raw',
        ],

    ],
]); ?>
<?/*= LinkPager::widget(['pagination' => $pagination]) */?>
