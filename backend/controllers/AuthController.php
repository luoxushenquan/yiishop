<?php
//权限操作
namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\AuthItem;
use backend\models\RoleForm;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
class AuthController extends Controller
{

    //rbac操作
    //添加权限
    public function actionAdd(){
        //负责操作rbac
        $auth = \yii::$app->authManager;
         $model = new AuthItem();
        $request = new Request();
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()){
                $permission = $auth->createPermission($model->name);
                //天加不起
                $permission->description=$model->description;
                $auth->add($permission);
                $this->redirect(['index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionIndex()
    {
        $auth = \yii::$app->authManager;
        $permission=  $auth->getPermissions();// 权限列表
//        $permission = $auth->getPermission('name');
        return $this->render('index',['permission'=>$permission]);
    }
    //删除权限
    public function actionDelete($name){
        $auth = \yii::$app->authManager;
        //查出一条
        $permission = $auth->getPermission($name);
        $auth->remove($permission);// 删除权限
        //跳转到权限列表
        return $this->redirect(['index']);
    }
    public function actionEdit($name){
        //负责操作rbac
        $auth = \yii::$app->authManager;
        $model = new AuthItem();
        $request = \yii::$app->request;
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()){

                $permission=$auth->getPermission($name);
                $permission->description=$model->description;

                $auth->update($name,$permission);
               return $this->redirect(['index']);
            }
        }

        $permission=$auth->getPermission($name);
        //如果权限不存在 提示
        if($permission==null){
            throw new NotFoundHttpException('权限不存在');
        }
        $model->name=$permission->name;
        $model->description=$permission->description;

        return $this->render('add',['model'=>$model]);
    }
//=>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>.
//=>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>.
//=>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>.
//=>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>.
    //天加角色

    public function actionAddrole(){
            $model=new RoleForm();
        $auth=\yii::$app->authManager;
        $request=\yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $role=$auth->createRole($model->name);
                $role->description=$model->description;
                $auth->add($role);//角色添加导数据表
                foreach ($model->permissions as $permissionName) {
                    $permission=$auth->getPermission($permissionName);
                    $auth->addChild($role,$permission);
                }
            //跳转角色列表
                return $this->redirect('roleindex');
            }
        }
         $permissions=$auth->getPermissions();
        $description= ArrayHelper::map($permissions,'name','description');
        return $this->render('add-role',['model'=>$model,'description'=>$description]);
    }
    //角色列表
    public function actionRoleindex(){
        $auth=\yii::$app->authManager;
        $role=$auth->getRoles();//角色列表
//        $role = $auth->getRole('name');
//        var_dump($role);exit;
        return $this->render('roleindex',['role'=>$role]);
    }
    public function actionRoledelete($role){
        $auth=\yii::$app->authManager;
        //查出一条
        $role = $auth->getRole($role);
        //删除一条
        $auth->remove($role);//删除角色
        return $this->redirect(['roleindex']);
    }
  public function actionRoleeedit($name){
      $model=new RoleForm();
      $auth=\yii::$app->authManager;
//      $request=\yii::$app->request;
//      if($request->isPost){
//          $model->load($request->post());
//          if($model->validate()){
//              $role=$auth->createRole($model->name);
//              $role->description=$model->description;
//              $auth->add($role);//角色添加导数据表
//              foreach ($model->permissions as $permissionName) {
//                  $permission=$auth->getPermission($permissionName);
//                  $auth->addChild($role,$permission);
//              }
//              //跳转角色列表
//              return $this->redirect('roleindex');
//          }
//      }
      $permission=$auth->getPermission($name);
      //如果权限不存在 提示
      if($permission==null){
          throw new NotFoundHttpException('权限不存在');
      }
      $model->name=$permission->name;
      $model->description=$permission->description;

      $permissions=$auth->getPermissions();
      $description= ArrayHelper::map($permissions,'name','description');
      return $this->render('add-role',['model'=>$model,'description'=>$description]);
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
