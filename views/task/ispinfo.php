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
use lo\widgets\SlimScroll;

$this->title = $tasks->name;
$this->params['breadcrumbs'][] = ['label' => "На исполнение", 'url' => ['isp']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?=$tasks->name ?></h1>
<div class="vvv">
<h4>Затрачено дней
    <span class="label label-pill label-primary label-as-badge" style="margin-left:10px"><?=$time?></span>
</h4>
</div>
<div class="row">
    <div class="col-md-6">
        <table style="width: 100%" id="task_tbl">
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
                    <td>
                        <?= SlimScroll::widget([
                            'options'=>[
                                'height'=>'250px'
                            ]
                        ]);
                        ?>
                        <p>
                            <?= $tasks->description ?>
                        </p>
                        <?= SlimScroll::end(); ?>
                    </td>
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
        <h3>Комментарии (<?=\app\models\Comment::find()->where(['task_id'=>Yii::$app->request->get('task_id')])->count()?>)</h3>
        <?php if (!empty($comments))
        {
            foreach($comments as $comment)
            {?>
                <b>
                    <?php
                    $start_date = date('d',strtotime($comment->date_time));
                    $end_date = date('d');
                    $comment_duration=$end_date-$start_date;
                    if($comment_duration === 0) echo $comment->user->name.", сегодня в ".date('H:i',strtotime($comment->date_time));
                    else if($comment_duration === 1) echo $comment->user->name.", вчера в ".date('H:i',strtotime($comment->date_time));
                    else echo $comment->user->name.", ".date('d.m.Y H:i',strtotime($comment->date_time));
                    ?>
                </b>
                <div class="well text-justify" style="word-wrap: break-word; border: 1px solid #dedede;"><?=$comment->text?></div>
                <?php
            }
        }
        else
        {?>
            Комментарии отсутствуют
            <?php
        }?>

        <?= LinkPager::widget(['pagination' => $pagination]); ?>

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($modelcom, 'text')->textarea(['name'=>'text','maxlength' => true,'style'=>'resize:none;'])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить комментарий', ['class' =>  'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
