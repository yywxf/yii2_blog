<?php
namespace frontend\components;

use yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * 标签云小部件
 */
class TagsCloudWidget extends Widget
{
    public $tags;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $tagStr = '';
        $fontStyle = [
            '2' => 'success',
            '3' => 'primary',
            '4' => 'warning',
            '5' => 'info',
            '6' => 'danger',
        ];
        foreach ($this->tags as $tag => $weight) {
            $url = Yii::$app->urlManager->createUrl(['post/index', 'PostSearch[tags]' => $tag]);
            $tagStr .= '<a href="' . $url . '"><h' . $weight . ' style="display:inline-block;"><span class="label label-' . $fontStyle[$weight] . '">' . $tag . '</span></h' . $weight . '></a> ';
        }
        return $tagStr;
    }
}