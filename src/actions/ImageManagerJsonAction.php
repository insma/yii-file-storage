<?php

/**
 * @link https://github.com/insma/yii2-file-storage
 * @copyright Copyright (c) 2015 Insma Software
 * @license https://github.com/insma/yii2-file-storage/wiki/LICENSE
 */

namespace insma\storage\actions;

use Yii;
use insma\storage\models\StorageItem;
use yii\web\HttpException;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * @author Maciej Klemarczyk <m.klemarczyk+dev@live.com>
 * @since 1.0
 */
class ImageManagerJsonAction extends \yii\base\Action
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!Yii::$app->request->isAjax) {
            //throw new HttpException(403, 'This action allow only ajaxRequest');
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
		$models = StorageItem::find()->all();
		$results = [];
		if(Yii::$app->controller->module->webAccessUrl === false){
			foreach($models as $model){
				$filePath = Yii::$app->controller->module->getFilePath($model->file_path);
				$url = Url::to(['view', 'id' => $model->id]);
				$fileName = pathinfo($filePath, PATHINFO_FILENAME);
				$results[] = $this->createEntry($filePath, $url, $fileName);
			}
		}else{
			$onlyExtensions = array_map(function ($ext) {
				return '*.' . $ext;
			}, Yii::$app->controller->module->imageAllowedExtensions);
			$filesPath = FileHelper::findFiles(Yii::$app->controller->module->getStorageDir(), [
				'recursive' => true,
				'only' => $onlyExtensions
			]);
			if (is_array($filesPath) && count($filesPath)) {
				foreach ($filesPath as $filePath) {
					$url = Yii::$app->controller->module->getUrl(pathinfo($filePath, PATHINFO_BASENAME));
					$fileName = pathinfo($filePath, PATHINFO_FILENAME);
					$results[] = $this->createEntry($filePath, $url, $fileName);
				}
			}
		}
		return $results;
    }

    /**
     * @return array
     */
	protected function createEntry($filePath, $url, $fileName)
	{
		return [
			'thumb' => $url,
			'image' => $url,
			'title' => pathinfo($filePath, PATHINFO_FILENAME)
		];
	}
}
