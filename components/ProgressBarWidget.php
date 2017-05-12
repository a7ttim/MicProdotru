<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 10.05.2017
 * Time: 22:39
 */
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class ProgressBarWidget extends Widget
{
    public $value;
    public $percent;
    public function init()
    {
        parent::init();
        if ($this->value === null || $this->value < 1) {
            $this->percent = 0;
        }
        else{
            $this->percent = $this->value.'%';
        }
    }

    public function run()
    {
        return $this->render('progressbar', [
            'value' => $this->value,
            'percent' => $this->percent,
        ]);
    }
}