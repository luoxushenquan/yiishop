<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/9
 * Time: 11:28
 */
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();
echo $form->field($model,'description')->textInput();
echo '<input type="submit"class="btn btn-info" value="添加">';
 \yii\bootstrap\ActiveForm::end();