<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php
    // 第一种方法
    // $psObject = \common\models\Poststatus::find()->all();
    // $allStatus = \yii\helpers\ArrayHelper::map($psObject,'id','name');

    // 第二种方法
    // $psArray = Yii::$app->db->createCommand('select id,name from poststatus')->queryAll();
    // $allStatus = \yii\helpers\ArrayHelper::map($psArray,'id','name');

    // 第三种方法
    // $allStatus = (new \yii\db\Query())
    //     ->select(['name', 'id'])
    //     ->from('poststatus')
    //     ->indexBy('id')
    //     ->column();

    // 第四种方法 推荐:结合第一和第三
    // $allStatus = \common\models\Poststatus::find()
    //     ->select(['name', 'id'])
    //     ->orderBy('position')
    //     ->indexBy('id')
    //     ->column();
    ?>

    <?= $form->field($model, 'status')->dropDownList(
        \common\models\Poststatus::find()
            ->select(['name', 'id'])
            ->orderBy('position')
            ->indexBy('id')
            ->column(),
        ['prompt' => '请选择状态']) ?>

    <?= $form->field($model, 'author_id')->dropDownList(
        \common\models\Adminuser::find()
            ->select(['nickname', 'id'])
            ->indexBy('id')
            ->column(),
        ['prompt' => '请选择作者']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
