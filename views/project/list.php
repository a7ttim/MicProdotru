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
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
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
        <th class="text-center">
            Диаграмма
        </th>
    </tr>
    <?
    foreach ($projects as $project){
        ?>
        <tr>
            <td class="text-center">
                <?= $project->project_id; ?>
            </td>
            <td>
                <?= $project->name; ?>
            </td>
            <td>
                <?= $project->description; ?>
            </td>
            <td>
                <? echo Html::a(
                        'Подробнее',
                        Url::to(['project/info', 'project_id' => $project->project_id]),
                        ['class' => 'btn-link center-block']
                )
                ?>
            </td>
            <td>
                <? echo Html::a(
                        'Подробнее',
                        Url::to(['project/gantt', 'project_id' => $project->project_id]),
                        ['class' => 'btn-link center-block']
                )
                ?>
            </td>
        </tr>
        <?
    }
    ?>
    </tbody>
</table>
<?= LinkPager::widget(['pagination' => $pagination]) ?>
