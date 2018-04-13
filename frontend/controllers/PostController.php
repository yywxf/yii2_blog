<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\Tag;
use common\models\User;
use frontend\components\RecentCommentsWidget;
use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public $added = 0; // 0表示还没有新回复

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tags = Tag::findTagWeights();
        $recentComments = Comment::findRecentComment();

        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags' => $tags,
            'recentComments' => $recentComments,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 文章详情页面
     * @author Fang Zenghua
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail($id)
    {
        // step1. 准备数据模型
        $model = $this->findModel($id);
        $tags = Tag::findTagWeights();
        $recentComments = Comment::findRecentComment();

        $user = User::findOne(Yii::$app->user->id);
        $commentModel = new Comment();
        $commentModel->userid = $user->id;
        $commentModel->email = $user->email;

        // step2. 提交评论
        if ($commentModel->load(Yii::$app->request->post())) {
            $commentModel->status = 1;  // 新评论默认状态 待审核
            $commentModel->post_id = $id;
            if ($commentModel->save()) {
                $this->added = 1; // 新回复
            }
        }

        // step3. 渲染视图
        return $this->render('detail', [
            'model'          => $model,
            'tags'           => $tags,
            'recentComments' => $recentComments,
            'commentModel'   => $commentModel,
            'added'          => $this->added,
        ]);
    }
}
