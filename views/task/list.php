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

?>
<table class="table table-responsive table-bordered">
    <tbody>
    <tr>
        <th class="text-center">
            #
        </th>
        <th>
            Имя
        </th>
        <th>
            Описание
        </th>
        <th class="text-center">
            Ссылка
        </th>
    </tr>
    <?
	if(count($tasks)>0) {
    foreach ($tasks as $task){
        ?>
        <tr>
            <td class="text-center">
                <?= $task->task_id; ?>
            </td>
            <td>
                <?= $task->name; ?>
            </td>
            <td>
                <?= $task->description; ?>
            </td>
            <td>
                <a href="../task/info?task_id=<?= $task->task_id; ?>" class="btn btn-info center-block">
                    Подробнее
                </a>
            </td>
        </tr>
        <?
    }}
    ?>
    </tbody>
</table>
<?= LinkPager::widget(['pagination' => $pagination]);?>
