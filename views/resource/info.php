<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Employment;
use app\models\Task;
use app\models\Project;
use yii\helpers\ArrayHelper;

$this->params['breadcrumbs'] = null;
$this->title = 'Информация о сотруднике';
$this->params['breadcrumbs'][] = ['label' => "Список ресурсов", 'url' => ['list']];
$this->params['breadcrumbs'][] = $usr['department_name'];
?>
<div style="display:flex">
	<h2><?=$usr['name']?>, </h2>
	<h2 class="dop"> <?=$usr['post_name']?></h2>
</div>
<div style="display:flex">
	<h4>Загруженность:</h4> 
	<div class='isp_progr'>
	<?=Html::decode(\app\components\ProgressBarWidget::widget(['value' => $workload,]));?></div>
    <h4>Проекты
        <span class="pull-right label label-pill label-primary label-as-badge" style="margin-left:10px"><?=$count_project?></span>
    </h4>
	<h4 style="margin-left: 1%">Задачи на исполнении
		<span class="pull-right label label-pill label-primary label-as-badge" style="margin-left:10px"><?=$count_isp?></span>
	</h4>
    <h4 style="margin-left: 1%">Задачи на согласовании
        <span class="pull-right label label-pill label-primary label-as-badge" style="margin-left:10px"><?=$count_sogl?></span>
    </h4>
    <h4 style="margin-left: 1%">Завершенные задачи
        <span class="pull-right label label-pill label-success label-as-badge" style="margin-left:10px"><?=$count_compl?></span>
    </h4>
    <h4 style="margin-left: 1%">Отклоненные задачи
        <span class="pull-right label label-pill label-danger label-as-badge" style="margin-left:10px"><?=$count_cansl?></span>
    </h4>
</div>

   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => 'name',
            ],
			[
                'attribute' => 'project_id',
                'value' => 'project.name',
                'filter'=>ArrayHelper::map(Project::find()
                    ->joinWith('tasks')
                    ->where(['task.user_id' => Yii::$app->request->get('user_id')])
                    ->asArray()
                    ->all(),
                    'project_id', 'name'),
                'label'=>'Проект'
            ],
			[
				'attribute' => 'start_date',
				'value' => function (Task $task) {
					$dt = new DateTime($task->start_date);
					return $dt->format('d.m.Y');
				},
				'format' => 'html',
			],
            [
                'attribute' => 'plan_duration',
				'label' => 'Дата завершения',
				'value' => function (Task $task) {
                    $dt = new DateTime($task->start_date);
					$dt->add(new DateInterval('P'.$task->plan_duration.'D'));
					return $dt->format('d.m.Y');
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