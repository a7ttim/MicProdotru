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
$script = <<< JS

gantt.config.columns =  [
    {name:"text",       tree:true, width:'*' }
];

gantt.config.subscales = [
    {unit:"year", step:1, date:"%Y год"}
];

gantt.templates.task_text = function(start,end,task){
    if(task.duration === 1 || task.duration === 2) return task.progress*100 + "%";
    else return "<b>Загруженность исполнителя: </b>" + Math.round(task.progress*100) + "%";
};

gantt.templates.tooltip_text = function(start, end, task){ 
    if (task.parent === 0)     return "<b> Завершено: </b>" + task.complete_percentage  + 
    "%" + "<br><b>Длительность (в днях): </b>" + task.duration;
    else return   "<b>Проект: </b>" + task.projectname + "<br><b>Описание задачи: </b>" + task.description + "<br><b> Завершено: </b>" + task.complete_percentage  + 
    "%" + "<br><b>Длительность (в днях): </b>" + task.duration;
}

gantt.config.readonly = true;

        gantt.init("gantt_here");
        gantt.parse({
          data:[      
JS;


/*            text:"' . $user->user->getTasks()->one()->name . '",


              duration:"' . $employment->user->getTasks()->sum('plan_duration') . '"
*/

/*    $diff = strtotime($employment->user->getTasks()->orderBy('end_date DESC')->one()->end_date) - strtotime($employment->user->getTasks()->orderBy('start_date ASC')->one()->start_date);
    $days = $diff / 60 / 60 / 24;
*/
foreach ($employments as $employment) {
    /*$total_compl = array();
    foreach($tasks as $task)
    {
        array_push($total_compl, \app\models\Task::find()->joinWith('user')->select('task.complete_percentage')->where(['user.user_id' => $employment->user_id])->one());
        $total_compl = array_sum($total_compl);
        $total_compl = $total_compl / count($tasks);
        print_r($total_compl);
    }*/

    if($employment->user->getTasks()->where(['not in', 'status_id', [1,4,6]])->count()>0){
        $complete_percentage = $employment->user->getTasks()->where(['not in', 'status_id', [1,4,6]])->sum('complete_percentage')/$employment->user->getTasks()->where(['not in', 'status_id', [1,4,6]])->count();

        $script .= '{
            id:' . $employment->employment_id . ',
            text:"' . $employment->user->name . '",
            start_date:"' . date('d.m.Y', strtotime($employment->user->getTasks()->min('start_date'))) . '",
            progress: ' . (($employment->user->getTasks()->where(['not in', 'status_id', [1,4,6]])->sum('employment_percentage')>100)
                ? $employment->user->getTasks()->where(['not in', 'status_id', [1,4,6]])->sum('employment_percentage')/100
                : $employment->user->getTasks()->where(['not in', 'status_id', [1,4,6]])->sum('employment_percentage')/100) .',
            complete_percentage: ' . $complete_percentage . ',
            duration:' . $employment->user->getTasks()->max('start_date' + 'plan_duration') . ', //что тут происходит ваще
            color:"' . ($employment->user->getTasks()->where(['not in', 'status_id', [1,4,6]])->sum('employment_percentage')>100 ? "red" : "default") . '"
            },';
    }

}

foreach ($tasks as $task) {
    if ($task->status_id === 1 || $task->status_id === 4 || $task->status_id === 6) continue;
    else {
        $script .= '{
            id:' . $task->task_id . ',
            text:"' . $task->name . '",
            description:"' . $task->description . '",
            start_date:"' . date('d.m.Y', strtotime($task->start_date)) . '",
            duration:' . $task->plan_duration . ',
            progress: 0.' . $task->employment_percentage . ',
            complete_percentage: ' . $task->complete_percentage . ',
            projectname:"' . $task->project->name . '",
            parent:' . ($task->user->user_id === \app\models\Task::find()->joinWith('user')->select('user.user_id')->where(['task.task_id' => $task->parent_task_id])->one()->user_id
                ? $task->parent_task_id : $task->user->getEmployments()->one()->employment_id) . '},';
    }
}
/*
\app\models\Task::find()->joinWith('user')->select('user.user_id')->where(['task.task_id'=>$task->parent_task_id])->one()
($task->user->name === $task->user->where(['task_id'=>$task->parent_task_id])->name ? $task->parent_task_id : $task->user->getEmployments()->one()->employment_id) */
$script .= <<< JS
   ], 
   links:[      
JS;

foreach ($links as $link){
    ($link->task_id % 2 === 0) ? $cnt = 2 : $cnt = 1;
    $script .= '{id:'.$link->task_id.', source:"'.$link->previous_task_id.'", target:"'.$link->task_id.'", type:'. $cnt .'},';
}
$script .= <<< JS
   ]
});
        
JS;
$this->registerJs($script, yii\web\View::POS_READY);
Pjax::end(); ?>

