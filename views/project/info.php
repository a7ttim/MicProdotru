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

?>
<h1>
    <?= $projectname ?>
</h1>
<!--<p>-->
<!--    --><?//= $projecdesc ?>
<!--</p>-->
<p>
    <?= Html::a('Новая задача', ['createtask'], ['class' => 'btn btn-success']) ?>
</p>


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
        //'user_id',
        [
            'attribute' => 'user_id',
            'value' => 'user.name',
        ],
        'description',
        // 'parent_task_id',
        // 'previous_task_id',
        // 'start_date',
        // 'plan_end_date',
        // 'fact_end_date',
        'employment_percentage',
        'status_id',
//            [
//                'attribute' => 'status',
//                'value' => 'status.status_name',
//            ],
//        [
//            'attribute' => 'status',
//            'filter' => array("1"=>"На согласовании","2"=>"На исполнении","3"=>"Завершена","4"=>"Удалена","5"=>"На исполнении"),
//        ],

        'complete_percentage',

        [
            'attribute' => ' ',
            'value' => function (Task $task) {
                return Html::a('Подробнее', Url::to(['showtask', 'id' => $task->task_id]));
            },
            'format' => 'raw',
        ],

    ],
]); ?>