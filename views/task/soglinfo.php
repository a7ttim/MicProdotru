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
use yii\bootstrap\Modal;
use yii\bootstrap\Progress;
use lo\widgets\SlimScroll;

$this->title = $tasks->name;
$this->params['breadcrumbs'][] = ['label' => "На согласование", 'url' => ['sogl']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?=$tasks->name ?></h1>
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
                                Url::to(['soglinfo', 'task_id' => $tasks->previous_task_id])
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
            <?= Html::submitButton('Принять', ['name'=>'ok', 'value' => '2', 'class' => 'btn btn-success']) ?>
            <?= Html::Button('Отклонить', ['class' => 'btn btn-danger','data-toggle'=>'modal', 'data-target'=>'#modal']) ?>
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

    <?php
    Modal::begin([
        'headerOptions' => ['id' => 'modalHeader','class'=>'text-center'],
        'header' => '<h2>Почему отказываетесь?</h2>',
        'id' => 'modal',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
        'options'=>['style'=>'min-width:20%']
    ]);?>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($modelcom, 'text')->textarea(['name'=>'mtext','maxlength' => true,'style'=>'resize:none;'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Подтвердить', ['name'=>'cancel','value' => '2','class' => 'btn btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>
