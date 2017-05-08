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

?>
<div style="margin-left: 50px"><h1>Задачи на согласование</h1></div>
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
                Завершение
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
                    <td> <?= $task['task_id']; ?></td>
                    <td> <?= $task['task'] ?></td>
                    <td> <?= $task['project'] ?></td>
                    <td>
                        <?php if (strlen($task['description'])>55) echo substr($task['description'] , 0, 52)."...";
                        else echo $task['description'];
                        ?>
                    </td>
                    <td> <?= date("d.m.y", strtotime($task['start_date'])) ?></td>
                    <td> <?= date("d.m.y", strtotime($task['plan_end_date'])) ?></td>
                    <td> <?= $task['employment_percentage'] ?></td>
                    <td><?= $task['user'] ?></td>
                    <td>
                        <?= Html::a(
                            'Подробно',
                            Url::to(['task/soglinfo', 'task_id' => $task['task_id']])
                        );
                        ?>
                    </td>
                </tr>
            <?php }
        }
        ?>
        </tbody>
    </table>
    <div style="margin-left: 50px;">
        <?= LinkPager::widget(['pagination' => $pagination]); ?>
    </div>
</div>
<?php Pjax::end(); ?>
