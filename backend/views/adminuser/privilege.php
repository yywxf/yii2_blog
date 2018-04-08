<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Adminuser;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$model = Adminuser::findOne($id);

$this->title = '权限设置: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '权限设置';
?>
<div class="adminuser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="adminuser-privilege-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::checkboxList('newPri',$authAssignmentsArray,$allPrivilegesArray) ?>

        <div class="form-group">
            <?= Html::submitButton('设置', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
