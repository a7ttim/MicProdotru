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

$this->title = $tasks->name;
$this->params['breadcrumbs'][] = ['label' => "На согласование", 'url' => ['sogl']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Задача №<?=$tasks->task_id ?> "<?=$tasks->name ?>"</h1>
<div>
    <table class="detailed">
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
                    <td style="display: block; max-height: 300px; overflow-y: auto; overflow-x: hidden;"><?= $tasks->description ?></td>
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
                                Url::to(['task/soglinfo', 'task_id' => $tasks->previous_task_id])
                            );
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
        </tbody>
    </table>

    <div class="form-group" style="margin-top: 2%">
        <?= Html::beginForm(['sogl'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
        <?= Html::submitButton('Принять', ['name'=>'ok','class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Отклонить', ['name'=>'cancel','class' => 'btn btn-danger']) ?>
        <?php
            if($_POST['ok']){
            $tasks->status_id=2;
            $tasks->save();
        ?>
        <?= Yii::$app->db->createCommand()->update('task', ['status_id' => 2], ['task_id' => $tasks->task_id])->execute();?>

        <?php }
            if($_POST['cancel']){
            $tasks->status_id=5;
            $tasks->save();?>
            <?= Yii::$app->db->createCommand()->update('task', ['status_id' => 5], ['task_id' => $tasks->task_id])->execute();
        ?>
        <?php }?>

    </div>
        <?= Html::endForm() ?>
</div>