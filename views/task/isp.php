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
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use app\models\Task;
use yii\i18n\Formatter;

$this->title = 'На исполнение';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'project_id',
                'value' => 'project.name',
            ],
            [
                'attribute' => 'description',
                'format' => 'text',
                'value' => function ($model){
                    return StringHelper::truncate($model->description, 25);
                }
            ],
            [
                'attribute' => 'start_date',
                'format' => ['date', 'php:d.m.Y']
            ],
            'plan_duration',
            [
                'attribute' => 'employment_percentage',
                'value' => function (Task $task) {
                    return Html::decode(\app\components\ProgressBarWidget::widget([
                        'value' => $task->employment_percentage,
                    ]));
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'complete_percentage',
                'value' => function (Task $task) {
                    return Html::decode(\app\components\ProgressBarWidget::widget([
                        'value' => $task->complete_percentage,
                    ]));
                },
                'format' => 'html',
            ],
            [
                'value' => function (Task $task) {
                    return Html::a('Подробнее', Url::to(['ispinfo', 'task_id' => $task->task_id]),['class' =>'btn btn-info btn-xs']);
                },
                'format' => 'raw',
            ],

        ],
    ]); ?>

<?php Pjax::end(); ?>
