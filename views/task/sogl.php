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
$this->title = 'На согласование';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>На согласование</h1>
<?php Pjax::begin(); ?>
<div>
    <table>
        <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                Название
            </th>
            <th>
                Проект
            </th>
            <th>
                Описание
            </th>
            <th>
                Начало
            </th>
            <th>
                Длительность
            </th>
            <th>
                Загруженность, %
            </th>
            <th>
                Исполнитель
            </th>
            <th>
                Подробно
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(count($tasks)>0) {
            foreach ($tasks as $task) {
                ?>
                <tr>
                    <td> <?= $task->task_id; ?></td>
                    <td> <?= $task->name ?></td>
                    <td> <?= $task->project->name ?></td>
                    <td>
                        <?php if (strlen($task->description)>55) echo substr($task->description , 0, 52)."...";
                        else echo $task->description;
                        ?>
                    </td>
                    <td> <?= date("d.m.y", strtotime($task->start_date)) ?></td>
                    <td> <?= $task->plan_duration ?></td>
                    <td> <?= $task->employment_percentage ?></td>
                    <td><?= $task->user->name ?></td>
                    <td>
                        <?= Html::a(
                            'Подробно',
                            Url::to(['soglinfo', 'task_id' => $task->task_id])
                        );
                        ?>
                    </td>
                </tr>
            <?php }
        }
        ?>
        </tbody>
    </table>
        <?= LinkPager::widget(['pagination' => $pagination]); ?>
</div>
<?php Pjax::end(); ?>
