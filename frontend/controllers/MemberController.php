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
use frontend\components\Sms;
class MemberController extends Controller{
    public $enableCsrfValidation=false;
    public function actionLogin(){
        //登录表单
//        exit;
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post(),'');
            if($model->validate()){
                if($model->login($model)){
                    //提示 跳转
                \Yii::$app->session->setFlash('success','登录成功');
                   return $this->redirect(['goods/index']);
                }else{
                    \Yii::$app->session->setFlash('success','登录失败请重新登录');
                    return $this->render('login');
                }
        }
        }
        return $this->render('login');

    }
//验证用户名是否存在
    public function actionName($username){

        $model=new Member();
        $request = \Yii::$app->request;
        $username = $model->findOne()->where(['username'=>$username]);
        if($username){
            return 'false';
        }
        return 'true';
    }

    //用户注册
    public function actionAdd(){
//        echo '2';exit;
        $model = new Member();
        $request = new Request();
//        var_dump($request->Post);exit;
        if($request->isPost){
            $model->load($request->post(),'');
//            exit;
//            var_dump($model->validate());exit;
            if($model->validate()){

                $model->created_at=time();
                //自动登录用的创建用户时需要设置auth_key  修改密码重新生成(更安全
                $model->auth_key=time().'2233';//随机字符串

                $model->password_hash=\yii::$app->security->generatePasswordHash($model->password_hash);
                $model->save(0);
                //分配角色
                \Yii::$app->session->setFlash('success', '账号申请成功');
                return $this->redirect(['member/login']);
            }
        }
        return $this->render('add');
    }
    //AJAX发送短信  后台AJAX发送短信功能:
    public function actionAjaxSms($phone){
        //测试
//        var_dump($phone);exit;
        //发送短信
        $rand=rand(1111,9999);
        $response = Sms::sendSms(
            "西边太阳商贸", // 短信签名
            "SMS_109520467", // 短信模板编号
            $phone, // 短信接收者
            Array(  // 短信模板中字段的值
                "code"=>$rand
                //"product"=>"dsd"
            )
        );
        //保存到redis
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        //测试保存久点
        $redis->set('captcha_'.$phone,$rand,60*60);


        return 'sucess';// 'fail'

    }
    //验证手机验证码
    public function actionCheckSms($sms,$tel){
//        var_dump($sms.$tel);exit;
        $redis = new \Redis();
        //从redis获取验证码
        $code = $redis->get('captcha_'.$tel);
        //验证验证码
        if($code == $sms.$tel){
            return 1;
        }
    }


}