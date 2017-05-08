<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['info','project_id' =>$model->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['updatetask', 'id' => $model->task_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['deletetask', 'id' => $model->task_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'task_id',
            'name',
            'project_id',
            'user_id',
            'description',
            //'parent_task_id',
            //'previous_task_id',
            'start_date',
            //'plan_end_date',
            //'fact_end_date',
            'employment_percentage',
            //'status',
            'complete_percentage',
        ],
    ]) ?>
</div>



<!--<div class="box-header orange-background">-->
<!--    <div class="title">-->
<!--        <i class="fa fa-comments-o"></i>-->
<!--        Chat-->
<!--    </div>-->
<!--    <div class="actions">-->
<!--        <a class="btn box-remove btn-xs btn-link" href="#"><i class="fa fa-times"></i>-->
<!--        </a>-->
<!--        <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>-->
<!--        </a>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="box-content box-no-padding">-->
<!--    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="scrollable" data-scrollable-height="300" data-scrollable-start="bottom" style="overflow: hidden; width: auto; height: 300px;">-->
<!--            <ul class="list-unstyled list-hover list-striped">-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Staci</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="October 20, 2016 - 22:45">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Tempore debitis rerum voluptatum repellat esse et est saepe sunt-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Staci</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="October 20, 2016 - 22:44">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Doloremque ducimus mollitia et adipisci-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Staci</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="October 20, 2016 - 22:43">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Error velit excepturi in ut et quo eos molestiae voluptatem architecto sequi-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Staci</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="" data-original-title="October 20, 2016 - 22:42">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Deleniti alias suscipit dolor hic non voluptas veniam laudantium est reiciendis hic inventore omnis omnis-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Staci</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="October 20, 2016 - 22:41">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Eum consectetur earum voluptatem aliquid id-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Niall</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="October 20, 2016 - 22:40">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Et asperiores voluptate velit et deserunt maxime repellendus nihil dolorem repudiandae itaque at-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Staci</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="" data-original-title="October 20, 2016 - 22:39">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Ut non occaecati voluptatum debitis cumque hic facere sapiente architecto cum vitae molestiae alias-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Staci</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="October 20, 2016 - 22:38">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Ut et quaerat quia quia ipsum reiciendis-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Staci</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="October 20, 2016 - 22:37">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Et assumenda minus laudantium qui-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class="message">-->
<!--                    <div class="avatar">-->
<!--                        <img alt="Avatar" src="assets/images/avatar.jpg" width="23" height="23">-->
<!--                    </div>-->
<!--                    <div class="name-and-time">-->
<!--                        <div class="name pull-left">-->
<!--                            <small>-->
<!--                                <a class="text-contrast" href="#">Niall</a>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                        <div class="time pull-right">-->
<!--                            <small class="date pull-right text-muted">-->
<!--                                <span class="timeago fade has-tooltip in" data-placement="top" title="" data-original-title="October 20, 2016 - 22:36">7 months ago</span>-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </small>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="body">-->
<!--                        Sunt vel id molestias hic iusto optio-->
<!--                    </div>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </div><div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 134.529px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div></div>-->
<!--    <form action="#" accept-charset="UTF-8" class="new-message" method="post"><input autocomplete="off" class="form-control" id="message_body" name="message[body]" placeholder="Type your message here..." type="text">-->
<!--        <button class="btn btn-success" type="submit">-->
<!--            <i class="fa fa-plus"></i>-->
<!--        </button>-->
<!--    </form>-->
<!--</div>-->