<?php
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Employment;

$this->title = 'Диаграмма Гантта';
$this->params['breadcrumbs'][] = ['label' => "Список ресурсов", 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;


Pjax::begin();
?>
<div id="gantt_here" style='height:400px;'></div>
<?php
//начало многосточной строки, можно использовать любые кавычки

$script = <<< JS

gantt.config.columns =  [
    {name:"text",       tree:true, width:'*' }
];

gantt.config.subscales = [
    {unit:"year", step:1, date:"%Y год"}
];

gantt.templates.task_text = function(start,end,task){
    if(task.parent) return task.progress*100 + "%";
    else return task.progress*100 + "%";
};

gantt.templates.tooltip_text = function(start, end, task){ 
    if(task.id === 1) return "<b> Менеджер проекта:</b> " + task.executor + "<br><b>Длительность (в днях):</b> " + task.duration;
    else return "<b> Исполнитель:</b> " + task.executor  + "<br><b>Длительность (в днях):</b> " + task.duration;;
}

gantt.config.readonly = true;

        gantt.init("gantt_here");
        gantt.parse({
          data:[      
JS;
/*            text:"' . $user->user->getTasks()->one()->name . '",


              duration:"' . $employment->user->getTasks()->sum('plan_duration') . '"
*/

foreach ($employments as $employment) {
    $script .= '{
            id:' . $employment->employment_id . ',
            text:"' . $employment->user->name . '",
            start_date:"' . date('d.m.Y', strtotime($employment->user->getTasks()->orderBy('start_date ASC')->one()->start_date)) . '",
            progress: ' . (($employment->user->getTasks()->sum('employment_percentage')>100) ? $employment->user->getTasks()->sum('employment_percentage')/100 : $employment->user->getTasks()->sum('employment_percentage')/100) .',
            duration:"' . $employment->user->getTasks()->orderBy('plan_duration DESC')->one()->plan_duration . '",
            color:"' . ($employment->user->getTasks()->sum('employment_percentage')>100 ? "red" : "default") . '"
            },';
}

foreach ($tasks as $task) {
    $script .= '{
            id:' . $task->task_id . ',
            text:"' . $task->name . '",
            start_date:"' . date('d.m.Y', strtotime($task->start_date)) . '",
            duration:'.$task->plan_duration.',
            progress: 0.'.$task->employment_percentage.',
            parent:'.$task->user->getEmployments()->one()->employment_id .'},';
}
$script .= <<< JS
   ], 
   links:[      
JS;
foreach ($links as $link){
    $script .= '{id:'.$link->task_id.', source:"'.$link->parent_task_id.'", target:"'.$link->task_id.'", type:1},';
}
$script .= <<< JS
   ]
});
        
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
Pjax::end(); ?>

