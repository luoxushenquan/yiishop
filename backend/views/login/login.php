<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/8
 * Time: 13:05
 */

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username')->textInput();
echo $form->field($model,'password_hash')->passwordInput();
//echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className());
echo $form->field($model,'remember')->checkbox();
echo '<input type="submit"class="btn-info"value="登录">';
\yii\bootstrap\ActiveForm::end();