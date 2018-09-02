<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\UploadForm;
use yii\web\UploadedFile;

class LoadController extends Controller
{
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
} 
?>