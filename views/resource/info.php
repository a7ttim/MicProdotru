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
<table style='width:100%; margin-bottom:30px;'>
<tr>
	<td class='inf'><h2><?=$usr['name']?>,</h2></td>
	<td class='inf'><h2 class='dop'><?=$usr['post_name']?></h2></td>
</tr>
<tr>
	<td class='inf'><h4>Загруженность:</h4></td>
	<td class='inf'><?=Html::decode(\app\components\ProgressBarWidget::widget([
                        'value' => $workload,]));?></td>
</tr>
</table>

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
				'label' => 'Название проекта',
                'value' => 'project.name',
            ],
			[
				'attribute' => 'start_date',
				'value' => function (Task $task) {
					$dt = new DateTime($task->start_date);
					return $dt->format('d-m-Y');
				},
				'format' => 'html',
			],
            [
                'attribute' => 'plan_duration',
				'label' => 'Дата завершения',
				'value' => function (Task $task) {
                    $dt = new DateTime($task->start_date);
					$dt->add(new DateInterval('P'.$task->plan_duration.'D'));
					return $dt->format('d-m-Y');
                },
				'format' => 'html',
			],
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
        ],
    ]); ?>