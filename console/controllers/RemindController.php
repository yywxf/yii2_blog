<?php

namespace console\controllers;

use common\models\Comment;
use yii\console\Controller;

/**
 * 定时任务新评论提醒
 */
class RemindController extends Controller
{
    public function actionSend()
    {
        $newCommentCount = Comment::find()->where(['remind' => 0, 'status' => 1])->count();
        if ($newCommentCount > 0) {
            $content = '有' . $newCommentCount . '条新评论待审核';
            if ($this->sendEmail($content)) {
                Comment::updateAll(['remind' => 1]);
                echo '[' . date('Y-m-d H:i:s') . '] ' . $content . PHP_EOL;
            }
            return 0;
        }
    }

    protected function sendEmail($content){
        $rs = \Yii::$app->mailer->compose()
            ->setFrom('87423932@qq.com')
            ->setTo('fangzenghua@qq.com')
            ->setSubject('博客评论提醒')
            // ->setTextBody('text body')
            ->setHtmlBody($content)
            ->send();
        return $rs;
    }

}