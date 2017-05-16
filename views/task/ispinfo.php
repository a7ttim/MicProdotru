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
                        <td>Выполнено</td>
                        <td>
                            <?= Progress::widget([
                                'percent' => $tasks->complete_percentage,
                                'label' => $tasks->complete_percentage."%",
                                'barOptions' => ['class' => 'progress-bar-success']
                                ]);
                            ?>
                            <?= Html::beginForm('', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
                            <div id="cp" style="display: inline;">
                            <div style="width: 30%; float: left; margin-top: 5%"> <?= Html::input('number', 'cp', $tasks->complete_percentage, ['class' => 'form-control','min'=>1,'max'=>100,'step'=>1]) ?></div>
                            <div style="float: left; margin-top: 6.5%"><?= Html::submitButton('Принять', ['class' => 'btn btn-sm btn-success']) ?></div>
                            </div>
                            <?= Html::endForm() ?>
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
<div class="form-group" style="margin-top: 2%">
    <?= Html::beginForm('', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::submitButton('ЗАВЕРШИТЬ', ['name'=>'complete', 'value' => '3', 'class' => 'btn btn-lg btn-success']) ?>
    <?= Html::endForm() ?>
</div>