<?php

use yii\helpers\Html;

?>

<div class="post">

    <div class="title">
        <h3><a href="<?= $model->url ?>"><?= Html::encode($model->title) ?></a></h3>
    </div>
    <div class="author">
        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
        <em><?= date('Y-m-d H:i:s', $model->create_time) ?></em>&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        <em><?= Html::encode($model->author->nickname) ?></em>
    </div>

    <br/>
    <div class="content">
        <?= $model->shortcontent ?>
    </div>

    <br/>
    <div class="nav">
        <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
        <?= implode(', ', $model->tagLinks) ?>
        <br/>
        <?= Html::a("评论({$model->commentCount})", $model->url . '#comments') ?> |
        最后修改于 <?= date('Y-m-d H:i:s', $model->update_time); ?>
    </div>

</div>
