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
use app\models\Task;
use yii\bootstrap\Modal;
use yii\bootstrap\Progress;

$this->title = $tasks->name;
$this->params['breadcrumbs'][] = ['label' => "На исполнение", 'url' => ['isp']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?=$tasks->name ?></h1>
<div style="display:flex">
<h4>Затрачено дней
    <span class="pull-right label label-pill label-primary label-as-badge" style="margin-left:10px"><?=$time?></span>
</h4>
</div>
<div class="row">
    <div class="col-md-6">
        <table style="width: 100%">
            <thead>
                <tr>
                    <th>
                        Общая информация
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Название</td>
                    <td><?=$tasks->name ?></td>
                </tr>
                <tr>
                    <td>Проект</td>
                    <td><?=$tasks->project->name ?></td>
                </tr>
                <tr>
                    <td>Начало</td>
                    <td><?=date("d.m.Y",strtotime($tasks->start_date)) ?></td>
                </tr>
                <tr>
                    <td>Плановое завершение</td>
                    <td><?= $plan_end_date ?></td>
                </tr>
                <tr>
                    <td>Загруженность</td>
                    <td>
                        <?= Progress::widget([
                            'percent' => $tasks->employment_percentage,
                            'label' => $tasks->employment_percentage."%",
                            'barOptions' => ['class' => 'progress-bar-success']
                        ]);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td  class="detailed"> <div style="max-height: 300px; overflow-y: auto;"><?= $tasks->description ?></div></td>
                </tr>
                <tr>
                    <td>Выполнено</td>
                    <td>
                        <?= Progress::widget([
                            'percent' => $tasks->complete_percentage,
                            'label' => $tasks->complete_percentage."%",
                            'barOptions' => ['class' => 'progress-bar-success']
                        ]);
                        ?>
                        <?php $form = ActiveForm::begin(); ?>
                        <div id="cp" class="row" style="margin-top: 2%">
                            <div class="col-md-6" style="margin-bottom: 2%"><?= $form->field($model, 'text')->textInput(['name'=>'cp','type'=>'number','value'=>$tasks->complete_percentage, 'class' => 'form-control','min'=>1,'max'=>100,'step'=>1])->label(false) ?></div>
                            <div class="col-md-offset-1"><?= Html::submitButton('Принять', ['class' => 'btn btn-md btn-success']) ?></div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Департамент</td>
                    <td><?=$tasks->department->department_name ?></td>
                </tr>
                <?php if (!is_null($previous_task->name))
                {
                    ?>
                    <tr>
                        <td>Предыдущая задача</td>
                        <td>
                            <?= Html::a(
                                $previous_task->name,
                                Url::to(['ispinfo', 'task_id' => $tasks->previous_task_id])
                            );
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <div style="margin-top: 2%; margin-bottom: 2%">
            <?php $form = ActiveForm::begin(); ?>
            <?= Html::submitButton('ЗАВЕРШИТЬ', ['name'=>'complete', 'value' => '3', 'class' => ($tasks->complete_percentage==100) ?
                'btn btn-lg btn-success' : 'btn btn-lg btn-warning', 'data'=>['confirm' => 'Вы уверены, что хотите завершить задачу?']]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="col-md-6">
        <table  style="width: 100%">
            <thead>
                <tr>
                    <th>
                        Комментарии
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($comments))
                {
                    foreach($comments as $comment)
                    {?>
                        <tr>
                            <td><?=$comment->user->name.", ".date('d.m.Y H:i',strtotime($comment->date_time))?></td>
                        </tr>
                        <tr>
                            <td><?=$comment->text?></td>
                        </tr>
                        <?php
                    }
                }
                else
                {?>
                    <tr>
                        <td>Комментарии отсутствуют</td>
                    </tr>
                    <?php
                }?>
            </tbody>
        </table>
        <?= LinkPager::widget(['pagination' => $pagination]); ?>

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($modelcom, 'text')->textarea(['name'=>'text','maxlength' => true,'style'=>'resize:none;'])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить комментарий', ['class' =>  'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
