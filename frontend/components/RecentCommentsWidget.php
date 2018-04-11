<?php
namespace frontend\components;

use yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * 最近回复小部件
 */
class RecentCommentsWidget extends Widget
{
    public $recentComments;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $commentStr = '';

        foreach ($this->recentComments as $comment) {
            $commentStr .= '<div class="post"><div class="title"><p style="color:#777;font-style:italic;">'.nl2br($comment->content).'</p><p class="text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.Html::encode($comment->user->username).'</p><p style="font-size: 8pt;color: blue;"><a href="'.$comment->post->url.'">《'.Html::encode($comment->post->title).'》</a></p></div></div><hr/>';
        }
        return $commentStr;
    }
}