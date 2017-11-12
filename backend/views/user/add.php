<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/8
 * Time: 10:42
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username')->textInput();
echo $form->field($model,'password_hash')->passwordInput();
echo $form->field($model,'email')->textInput();
echo $form->field($model,'status')->radioList([0=>'禁用',1=>'启用']);
echo $form->field($model,'role',['inline'=>1])->checkboxList($roles);
echo '<input type="submit"class="btn btn-info">';
\yii\bootstrap\ActiveForm::end();