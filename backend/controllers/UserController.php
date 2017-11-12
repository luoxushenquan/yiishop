<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/8
 * Time: 10:38
 */

namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\User;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class UserController extends Controller{
    public function actionAdd(){
        $auth=\yii::$app->authManager;
        $model = new User();
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

                //删除角色
                $auth->revokeAll($model->getId());
//                var_dump($model->role);exit;
                foreach ($model->role as $v) {
                    $role=$auth->getRole($v);

                    $auth->assign($role,$model->getId());
                }

                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['index']);
            }
        }
        //查询角色
        $roles=$auth->getRoles();
        $roles= ArrayHelper::map($roles,'name','name');
        return $this->render('add',['model'=>$model,'roles'=>$roles]);
    }
    public function actionIndex(){

        $user=User::find();
        $pager = new Pagination();
        $pager->totalCount=$user->count();
        $pager->pageSize=5;
        $user = $user->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['user'=>$user,'pager'=>$pager]);
    }
    //删除用户
    public function actionDelete($id){
        $user = User::findOne(['id'=>$id]);
        $user->delete();
//        $user->status=0;
//        $user->save();
        $this->redirect(['index']);

    }
    public function actionJin($id){
        $user = User::findOne(['id'=>$id]);
        $user->status=0;
        $user->save();
        $this->redirect(['index']);

    }
    public function actionEdit($id){
        $auth=\yii::$app->authManager;
        $model = User::findOne(['id'=>$id]);
        $request=\yii::$app->request;
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

                //删除角色
                $auth->revokeAll($model->getId());
//                var_dump($model->role);exit;
                foreach ($model->role as $v) {
                    $role=$auth->getRole($v);

                    $auth->assign($role,$model->getId());
                }

                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['index']);
            }
        }
        //查询角色
        $roles=$auth->getRoles();
        $roles= ArrayHelper::map($roles,'name','name');
        return $this->render('add',['model'=>$model,'roles'=>$roles]);
    }
    public function behaviors()
   {
       return [
           'rbac'=>[
               'class'=>RbacFilter::className(),
               'except'=>['login']
           ]
       ];
   }
}