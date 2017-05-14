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

$this->title = \app\models\ProjectStatus::findOne(['status_id' => $status_id])->status_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>
    <?= $this->title ?>
</h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        [
            'attribute' => 'pm_id',
            'value' => 'pm.name',
        ],
        [
            'attribute' => 'description',
            'format' => 'text',
            'value' => function ($model){
                return StringHelper::truncate($model->description, 50);
            }
        ],
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
