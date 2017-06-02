<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Task;
use dosamigos\chartjs\ChartJs;
use kartik\date\DatePicker;

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class='period'>
<h4>Период:</h4>
<?php
$form = ActiveForm::begin(['id' => 'stat_res', 'enableAjaxValidation' => true]);
$layout = <<< HTML
    <span class="input-group-addon">С</span>
    {input1}
    {separator}
    <span class="input-group-addon">По</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;

echo DatePicker::widget([
    'type' => DatePicker::TYPE_RANGE,
    'name' => 'dp_addon_3a',
    'value' => $lstdt->format('d.m.Y'),
    'name2' => 'dp_addon_3b',
    'value2' => $lstdt->add(new DateInterval('P'.$curdt.'D'))->format('d.m.Y'),
    'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
    'layout' => $layout,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd.mm.yyyy'
    ]
]);

    $params = ['class' => "btn btn-info dropdown-toggle",
	'options' => $opt ];
    echo $form->field($model, 'status')->dropDownList($dd_items,$params)->label('Выберите проект');
	echo Html::submitButton('Получить', ['class' => 'btn btn-info', 'id' => 'proc']); 
    ActiveForm::end();
?>
</div>

<h3>Загруженность сотрудников в проектах по дням:</h3>
<div class='chart'>
<?=ChartJs::widget([
	'type' => 'bar',
	'data' => [
			'labels' => [],
			'datasets' => $datasets,
	],
])?>
</div>

<?
//print_r($datasets);
?>