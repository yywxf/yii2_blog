<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id 评论ID
 * @property string $content 内容
 * @property int $status 状态
 * @property int $create_time 创建时间
 * @property int $userid 用户ID
 * @property string $email Email
 * @property string $url
 * @property int $post_id 文章ID
 *
 * @property Post $post
 * @property Commentstatus $status0
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'status', 'userid', 'email', 'post_id'], 'required'],
            [['content'], 'string'],
            [['status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['email', 'url'], 'string', 'max' => 128],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Commentstatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'status' => '状态',
            'create_time' => '创建时间',
            'userid' => '用户ID',
            'email' => 'Email',
            'url' => 'Url',
            'post_id' => '文章ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Commentstatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    /**
     * 获取截取后的内容
     * @author Fang Zenghua
     * @param int $length
     * @return string
     */
    public function getShortcontent($length = 10)
    {
        $tmpStr = strip_tags($this->content);
        $tmpLen = mb_strlen($tmpStr);
        return mb_substr($tmpStr, 0, $length, 'utf-8') . ($tmpLen > $length ? '...' : '');
    }

    /**
     * 审核操作
     * @author Fang Zenghua
     * @return bool
     */
    public function approve()
    {
        $this->status = 2;  //设置评论状态为已审核
        return $this->save() ? true : false;
    }

    /**
     * 获取待审核评论数目
     * @author Fang Zenghua
     * @return int|string
     */
    public static function getPendingCommentCount()
    {
        return Comment::find()->where(['status' => 1])->count();
    }

    /**
     * 重写方法处理创建时间
     * @author Fang Zenghua
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
