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
<p>Период:</p>
<?php
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
    'value' => '01.08.2016',
    'name2' => 'dp_addon_3b',
    'value2' => '18.08.2016',
    'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
    'layout' => $layout,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd.mm.yyyy'
    ]
]);?>

<?=ChartJs::widget([
	'type' => 'bar',
	'data' => [
			'labels' => [],
			'datasets' => $datasets,
	]
])?>

<?
//print_r($datasets);
?>