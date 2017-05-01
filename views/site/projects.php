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
?>

<?
foreach ($projects as $project){
    ?>
    <tr>
        <td>
            <h3>
                <?= $project->name; ?>
            </h3>
        </td>
        <td>
            <p>
                <?= $project->description; ?>
            </p>
        </td>
    </tr>
<?
}
?>
    </table>
