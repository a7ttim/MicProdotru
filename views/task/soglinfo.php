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

$this->title = $tasks->name;
$this->params['breadcrumbs'][] = ['label' => "На согласование", 'url' => ['sogl']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Задача №<?=$tasks->task_id ?> "<?=$tasks->name ?>"</h1>
<div style="display: inline-block; width: 100%">
    <div style="width: 50%; float: left">
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
                        <td>Длительность</td>
                        <td><?= $tasks->plan_duration ?></td>
                    </tr>
                    <tr>
                        <td>Исполнитель</td>
                        <td><?=$tasks->user->name ?></td>
                    </tr>
                    <tr>
                        <td>Загруженность</td>
                        <td><?=$tasks->employment_percentage ?></td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td  class="detailed"> <div style="max-height: 300px; overflow-y: auto;"><?= $tasks->description ?></div></td>
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
    </div>
    <div style="width: 50%; float: left">
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
                        <td><?=$comment->user->name.", ".date('d.m.Y',strtotime($comment->date_time))?></td>
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
<div class="form-group" style="margin-top: 2%">
    <?= Html::beginForm('', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::submitButton('Принять', ['name'=>'ok', 'value' => '2', 'class' => 'btn btn-success']) ?>
    <?= Html::Button('Отклонить', ['class' => 'btn btn-danger','data-toggle'=>'modal', 'data-target'=>'#modal']) ?>
    <?= Html::endForm() ?>
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

    <?php Modal::end();
    ?>

</div>