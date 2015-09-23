<?php

namespace wolfguard\gallery\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * AdminController allows you to administrate galleries.
 *
 * @property \wolfguard\gallery\Module $module
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com
 */
class AdminController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'  => ['post'],
                    'delete-image'  => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index', 'create', 'update', 'delete',
                            'images', 'create-image', 'delete-image', 'update-image'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = $this->module->manager->createGallerySearch();
        $dataProvider = $searchModel->search($_GET);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->module->manager->createGallery(['scenario' => 'create']);

        $model->loadDefaultValues();

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            \Yii::$app->getSession()->setFlash('gallery.success', \Yii::t('gallery', 'Gallery has been created'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            if(\Yii::$app->request->get('returnUrl')){
                $back = urldecode(\Yii::$app->request->get('returnUrl'));
                return $this->redirect($back);
            }

            \Yii::$app->getSession()->setFlash('gallery.success', \Yii::t('gallery', 'Gallery has been updated'));
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Gallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->getSession()->setFlash('gallery.success', \Yii::t('gallery', 'Gallery has been deleted'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer                    $id
     * @return \wolfguard\gallery\models\Gallery the loaded model
     * @throws NotFoundHttpException      if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = $this->module->manager->findGalleryById($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $model;
    }


    /**
     * Lists all Gallery images models.
     *
     * @param $id Gallery id
     * @return mixed
     */
    public function actionImages($id)
    {
        $gallery = $this->findModel($id);

        $searchModel  = $this->module->manager->createGalleryImageSearch();
        $dataProvider = $searchModel->search($_GET);

        return $this->render('image/index', [
            'gallery' => $gallery,
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Create gallery image
     * @param $id Gallery id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCreateImage($id)
    {
        $gallery = $this->findModel($id);

        $model = $this->module->manager->createGalleryImage(['scenario' => 'create']);

        $model->loadDefaultValues();

        if ($model->load(\Yii::$app->request->post())) {
            $model->gallery_id = $gallery->id;
            if($model->create()) {
                \Yii::$app->getSession()->setFlash('gallery.success', \Yii::t('gallery', 'Image has been created'));
                return $this->redirect(['images', 'id' => $id]);
            }
        }

        return $this->render('image/create', [
            'gallery' => $gallery,
            'model' => $model
        ]);
    }

    /**
     * Updates an existing GalleryImage model.
     * If update is successful, the browser will be redirected to the 'images' page.
     *
     * @param  integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdateImage($id)
    {
        $model = $this->module->manager->findGalleryImageById($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested image does not exist');
        }
        $model->scenario = 'update';

        $gallery = $this->findModel($model->gallery_id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            if(\Yii::$app->request->get('returnUrl')){
                $back = urldecode(\Yii::$app->request->get('returnUrl'));
                return $this->redirect($back);
            }

            \Yii::$app->getSession()->setFlash('gallery.success', \Yii::t('gallery', 'Image has been updated'));
            return $this->refresh();
        }

        return $this->render('image/update', [
            'model' => $model,
            'gallery' => $gallery
        ]);
    }

    /**
     * Deletes an existing GalleryImage model.
     * If deletion is successful, the browser will be redirected to the 'images' page.
     *
     * @param  integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDeleteImage($id)
    {
        $model = $this->module->manager->findGalleryImageById($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        $model->delete();

        \Yii::$app->getSession()->setFlash('gallery.success', \Yii::t('gallery', 'Image has been deleted'));

        return $this->redirect(['images', 'id' => $model->gallery_id]);
    }
}
