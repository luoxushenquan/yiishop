<?php
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'market_price')->textInput();
echo $form->field($model,'shop_price')->textInput();
echo $form->field($model,'stock')->textInput();
echo $form->field($model2,'content')->widget('kucha\ueditor\UEditor');
\yii\bootstrap\ActiveForm::end();