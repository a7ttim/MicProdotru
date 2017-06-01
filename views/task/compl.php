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
use app\models\Project;
use yii\helpers\ArrayHelper;

$this->title = 'Завершенные';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'project_id',
                'value' => 'project.name',
                'filter'=>ArrayHelper::map(Project::find()
                    ->joinWith('tasks')
                    ->where(['task.user_id' => Yii::$app->user->identity->user_id])
                    ->asArray()
                    ->all(),
                    'project_id', 'name'),
                'label'=>'Проект'
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
            [
                'attribute' => 'fact_duration',
                'label' => 'Фактическое завершение',
                'value' => function (Task $task) {
                    $dt = new DateTime($task->start_date);
                    $dt->add(new DateInterval('P'.$task->fact_duration.'D'));
                    return $dt->format('d.m.Y');
                },
                'format' => 'html',
            ],
            [
                'value' => function (Task $task) {
                    return Html::a('Подробнее', Url::to(['complinfo', 'task_id' => $task->task_id]),['class' =>'btn btn-info btn-xs']);
                },
                'format' => 'raw',
            ],

        ],
    ]); ?>

<?php Pjax::end(); ?>
