<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/10
 * Time: 11:29
 */
//合并数组
//$items=array_merge([0=>'顶级菜单'],$items);
$permissions=array_merge([0=>'无'],$permissions);
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'class')->dropDownList([1=>'顶级菜单']+$items);
echo $form->field($model,'item')->dropDownList($permissions);
echo $form->field($model,'sort')->textInput();
echo '<input type="submit"class="btn btn-info" value="提交">';
\yii\bootstrap\ActiveForm::end();