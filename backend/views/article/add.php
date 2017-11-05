<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/4
 * Time: 12:02
 * id	primaryKey
name	varchar(50)	名称
intro	text	简介
article_category_id	int()	文章分类id
sort	int(11)	排序
status	int(2)	状态(-1删除 0隐藏 1正常)
create_time	int(11)	创建时间
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'intro')->textInput();
echo $form->field($model,'article_category_id')->dropDownList($items);
echo $form->field($model,'sort')->textInput();
echo $form->field($model,'status')->radioList([-1=>'删除',0=>'隐藏',1=>'正常']);
echo $form->field($model1,'content')->textarea();
echo '<input type="submit"class="btn btn-block">';
\yii\bootstrap\ActiveForm::end();