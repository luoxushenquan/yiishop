<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/10
 * Time: 16:23
 */
//��ȡ�û���Ӧ�Ĳ˵�
namespace backend\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Daohang extends ActiveRecord implements IdentityInterface{
    public function getMenus(){

        $menuItems=[];
        $menus = Menu::find()->where(['class'=>0])->all();
        foreach ($menus as $menu ) {
            $items=[];
            foreach($menu->children as $child){
               if( Yii::$app->user->can($child->url)){
                   $items[]=['label'=>$child->label,'url'=>[$child->url]];
               }
//                $items=[]=['label'=>$child->name,'url'=>[$child->url]];
            }

            $menuItems=['label'=>$menu->name,'items'=>$items];
            //���˵�����˵�������

            //���û�ж����˵�����ʾһ���˵�
            if($items){
                $menuItems[]=$menuItems;

            }
        }

        return $menuItems;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return  self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
}