<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\Post;

/**
 * 控制台命令程序练习
 */
class HelloController extends Controller
{
    public $rev;

    /**
     * 选项
     */
    public function options($actionID)
    {
        return ['rev'];
    }

    /**
     * 选项别名
     */
    public function optionAliases()
    {
        return ['r' => 'rev'];
    }

    /**
     * 默认动作
     * yii hello/index
     * yii hello
     * yii hello abc --rev=1
     * yii hello -r=1 abc
     */
    public function actionIndex($str = 'def')
    {
        // var_dump($this->rev);
        if ($this->rev === '1') {
            echo strrev('hello world!' . $str);
        } else {
            echo 'hello world!' . $str;
        }
    }

    public function actionList()
    {
        $posts = Post::find()->all();
        foreach ($posts as $post) {
            echo $post['id'] . '-' . $post['title'] . PHP_EOL;
        }
    }

    /**
     * yii hello/p1 aa
     */
    public function actionP1($param)
    {
        echo 'param is ' . $param;
    }

    /**
     * yii hello/p2 aa bb
     */
    public function actionP2($p1, $p2)
    {
        echo 'params are ' . $p1 . ' and ' . $p2;
    }

    /**
     * yii hello/arr aa,bb,cc
     */
    public function actionArr(array $arr)
    {
        var_dump($arr);
    }
}