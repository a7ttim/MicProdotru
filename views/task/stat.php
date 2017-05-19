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
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use app\models\Task;
use yii\i18n\Formatter;

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>
<div style="display: inline-block; width: 100%">
    <div style="width: 50%; float: left">
        <div>
            <?php $form = ActiveForm::begin(); ?>
           Период: с <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
                //'dateFormat' => 'yyyy-MM-dd',
            ])->label("с") ?>...по...
            <?php ActiveForm::end(); ?>
        </div>
        <div>
            <?= Html::beginForm(['stat'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
            <?php $items=[
                0=>'По проектам',
                1=>'По количеству'
            ];?>
            <?= Html::dropDownList('cat', 'По проекту', $items, ['class' => 'form-control','onchange'=>"document.getElementById('select' ).style.display = 'block';"]) ?>
            <div id="select" style="margin-top: 6px; display: none;"><?= Html::submitButton('Принять', ['class' => 'btn btn-lg btn-primary', 'name'=>'select']) ?></div>
            <?= Html::endForm() ?>
        </div>
    </div>
    <div style="width: 50%; float: left">
        <div>
            Проект: <?= $tasks->project->name?>
        </div>
        <div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,

                'columns' => [
                    [
                        'attribute' => 'name',
                        'label' => 'Задача',
                    ],
                    [
                        'attribute' => 'start_date',
                        'format' => ['date', 'php:d.m.Y']
                    ],
                    [
                        'attribute' => 'fact_duration',
                        'label' => 'Длительность',
                    ],
                    [
                        'attribute' => 'status_id',
                        'value' => 'status.status_name',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
