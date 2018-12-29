<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionAdmin()
    {
        $this->layout='backend';
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionIndex()
    {
        return $this->showIndex(Yii::$app->request->queryParams);
    }

    public function actionSocks()
    {
        return $this->showIndex(['show'=>'socks']);
    }
    public function actionSinglets()
    {
        return $this->showIndex(['show'=>'singlets']);
    }
    public function actionUnderwear()
    {
        return $this->showIndex(['show'=>'underwear']);
    }

    protected function showIndex($params){
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $relatedProvider = new ActiveDataProvider([
            'query' => Product::find()->where("id<>{$model->id} AND category_id={$model->category_id} AND public=1")->limit(16),
            'pagination' => false,
        ]);
        return $this->render('view', [
            'model' => $model,
            'relatedProvider'=>$relatedProvider
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $this->layout='backend';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
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
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionImgUpload(){
        $files=UploadedFile::getInstancesByName('Product[imageFiles]');
        $dir=Yii::getAlias('@webroot')."/images/product/";
        $id=Yii::$app->request->get('id');
        $tosave=$dir.$id;

        foreach($files as $image)
        {
            $time=time().'s'.rand(1, 100);
            $extension=$image->extension;
            $imageName=$time.'.'.$extension;

            $image->saveAs($tosave.'/' . $imageName);
            $imagine=Image::getImagine()->open($tosave.'/'.$imageName);
            $imagine->thumbnail(new Box(400, 250))->save($tosave.'/s_'.$imageName);
            $images[]=$imageName;
        }
        $images_str=implode(';',$images);
        $images_field=Yii::$app->db->createCommand("SELECT images FROM product WHERE id='{$id}'")->queryScalar();
        if($images_field){$images_str=$images_field.';'.$images_str;}
        Yii::$app->db->createCommand("UPDATE product SET images='{$images_str}' WHERE id='{$id}'")->execute();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [];
    }
}
