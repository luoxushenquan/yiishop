<?php
namespace backend\filters;

use yii\base\ActionFilter;
use yii\web\HttpException;
class RbacFilter extends ActionFilter{
    public function beforeAction($action)
    {
        //$action->uniqueId ��ǰ·��
        //return \Yii::$app->user->can($action->uniqueId);

        if(!\Yii::$app->user->can($action->uniqueId)){
            //���û�е�¼,����ת����¼ҳ��
            if(\Yii::$app->user->isGuest){
                //send()ȷ��������ת
                return $action->controller->redirect(\Yii::$app->user->loginUrl)->send();
            }else{
                throw new HttpException(403,'�Բ���,��û�иò���Ȩ��');
                return false;
            }

        }

        return parent::beforeAction($action);
    }
}