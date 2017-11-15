<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/13
 * Time: 16:19
 * //添加收获地址
 */
namespace frontend\controllers;
use frontend\models\Address;
use yii\web\Controller;
use yii\web\Request;

class AddressController extends Controller{
    public $enableCsrfValidation=false;
    public function actionAdd(){
//        exit;
        $model=new Address();
           $request=New Request();
        if($request->isPost){
            //验证不到
//            var_dump($request->post());exit;
            $model->load($request->post(),'');
            if($model->validate()){
                //获取登录信息
               $name = \Yii::$app->user->id;
//                var_dump($name);exit;
                $model->name=$name;
                $model->save(0);
//                echo '添加成功';exit;
                $this->redirect(['add']);
            }else{
                var_dump($model->getErrors());exit;
            }


        }
//        获取登录用户信息
        $name = \Yii::$app->user->id;
        $model = Address::find()->where(['name'=>$name])->all();
//        var_dump($model);exit;
        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($id){
        $model=Address::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['add']);
    }


}