<?php

/**
 * @link https://github.com/insma/yii2-file-storage
 * @copyright Copyright (c) 2015 Insma Software
 * @license https://github.com/insma/yii2-file-storage/wiki/LICENSE
 */

namespace insma\storage\controllers;

use Yii;
use insma\storage\models\StorageItem;
use insma\storage\models\FileUploadModel;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;

/**
 * @author Maciej Klemarczyk <m.klemarczyk+dev@live.com>
 * @since 1.0
 */
class FileController extends \yii\web\Controller
{

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['post'],
                ],
            ],
            'negotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }

    public function actionUpload()
    {
		$model = new FileUploadModel([
			'allowedExtensions' => Yii::$app->controller->module->fileAllowedExtensions,
		]);
		if ($model->upload()) {
			return $model->getResponse();
		} else {
			return ['error' => 'Unable to save file'];
		}
    }

	public function actionView($id){
		$model = $this->findModel($id);
		$filePath = Yii::$app->controller->module->getFilePath($model->file_path);
		if(is_file($filePath)){
			$handle = fopen($filePath, "r");
			$contents = fread($handle, filesize($filePath));
			fclose($handle);
			$this->layout = false;
			Yii::$app->response->format = Response::FORMAT_RAW;
			return $contents;
		}
		return null;
	}

    /**
     * Finds the StorageItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StorageItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StorageItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
