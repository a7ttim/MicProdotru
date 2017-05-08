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
?>
<div style="margin-left: 50px"><h1>Задача №<?=$tasks->task_id?> "<?=$tasks->name;?>"</h1></div>
<div style="display: inline-block; font-size: 25px">Длительность <div class="btn btn-primary btn-sm" ><?=$tasks->plan_end_date-$tasks->start_date;?></div></div>
<div>
    <table>
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
                    <td></td>
                </tr>
                <tr>
                    <td>Проект</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Начало</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Завершение</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Ответственный</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Загруженность</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Департамент</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Предыдущая задача</td>
                    <td></td>
                </tr>
        </tbody>
    </table>
</div>