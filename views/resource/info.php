<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Employment;
use app\models\Task;

$this->params['breadcrumbs'] = null;
$this->title = 'Информация о сотруднике';
$this->params['breadcrumbs'][] = ['label' => "Список ресурсов", 'url' => ['list']];
$this->params['breadcrumbs'][] = $usr['department_name'];
?>
<h2><?=$usr['name']?></h2>
<h4><?=$usr['post_name']?></h4>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => 'name',
            ],
			[
                'attribute' => 'project.name',
                'value' => 'project.name',
            ],
			'start_date',
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
        ],
    ]); ?>