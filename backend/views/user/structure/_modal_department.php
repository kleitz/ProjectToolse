<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<?= Alert::widget(); ?>

<div class="position-form col-lg-12 alert-info">

    <?php $form = ActiveForm::begin(['id' => 'department_form', 'method' => 'post', 'action' => Url::toRoute(['/department/create',])]); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?= Yii::t('app', 'Department'); ?></b></div>

        <div class="panel-body">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]); ?>

            <?php echo Html::hiddenInput('referrer', '/user/structure');?>

        </div>
    </div>

    <div class="pull-right">

        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']); ?>

    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>