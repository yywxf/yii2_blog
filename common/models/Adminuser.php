<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adminuser".
 *
 * @property int $id 管理员ID
 * @property string $username 用户名
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $nickname 昵称
 * @property string $password
 * @property string $email Email
 * @property string $profile
 *
 * @property Post[] $posts
 */
class Adminuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adminuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'nickname', 'password', 'email'], 'required'],
            [['profile'], 'string'],
            [['username', 'nickname', 'password', 'email'], 'string', 'max' => 128],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '管理员ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'nickname' => '昵称',
            'password' => 'Password',
            'email' => 'Email',
            'profile' => 'Profile',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['author_id' => 'id']);
    }
}
