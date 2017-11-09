<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/9
 * Time: 14:26
 */
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'name')->textInput();
echo $form->field($model,'description')->textInput();
echo $form->field($model,'permissions',['inline'=>1])->checkboxList($description);
echo '<input type="submit"class="btn btn-info" value="添加">';
\yii\bootstrap\ActiveForm::end();