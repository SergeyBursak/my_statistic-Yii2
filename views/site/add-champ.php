<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h1>Добавление Чемпионата</h1>

<?php $form = ActiveForm::begin();?>

<div class="row">
    <div class="col-xs-4">
        <?= $form->field($model,'name')->textInput()?>
        <?= $form->field($model,'matches_all')->input('integer')?>
        <?= $form->field($model,'matches_succcess')->input('integer')?>
        <?= $form->field($model,'percent_success')->input('integer')?>
        <?= Html::submitButton('Создать',['class' => 'btn btn-success'])?>
    </div>
</div>

<?php ActiveForm::end();?>
