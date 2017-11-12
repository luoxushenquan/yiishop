<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/12
 * Time: 12:53
 */
namespace frontend\controllers;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\web\Controller;
use yii\web\Request;

class MemberController extends Controller{
    public $enableCsrfValidation=false;
    public function actionLogin(){
        //登录表单
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post(),'');
            if($model->validate()){
                $model->login($model);
                //提示 跳转
//                \Yii::$app->session->setFlash('success','登录成功');
//                return $this->redirect(['brand/index']);
                echo '登陆成功';exit;
            }
        }
        return $this->render('login');
    }
//验证用户名是否存在
    public function actionName($username){

        $model=new Member();
        $username = $model->findOne()->where(['username'=>$username]);
        if($username){
            return 'false';
        }
        return 'true';
    }

    //用户注册
    public function actionAdd(){
        $auth=\yii::$app->authManager;
        $model = new Member();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
//                echo 'eee',exit;
                $model->created_at=time();
                //自动登录用的创建用户时需要设置auth_key  修改密码重新生成(更安全
                $model->auth_key=time().'2233';//随机字符串

                $model->password_hash=\yii::$app->security->generatePasswordHash($model->password_hash);
                $model->save(0);
                //分配角色
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }


}