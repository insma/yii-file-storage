<?php

/**
 * @link https://github.com/insma/yii2-file-storage
 * @copyright Copyright (c) 2015 Insma Software
 * @license https://github.com/insma/yii2-file-storage/wiki/LICENSE
 */

namespace insma\storage\models;

use Yii;
use insma\storage\models\StorageItem;
use yii\web\UploadedFile;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * @author Maciej Klemarczyk <m.klemarczyk+dev@live.com>
 * @since 1.0
 */
class FileUploadModel extends \yii\base\Model
{
    /**
     * @var array|null
     */
	public $allowedExtensions;

    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @var string
     */
    private $_fileName;

    /**
     * @var StorageItem
     */
    private $_model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			['file', 'required'],
            ['file', 'file', 'extensions' => $this->allowedExtensions],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstanceByName('file');
            return true;
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function upload()
    {
        if ($this->validate()) {
			if(Yii::$app->controller->module->databaseStorage === true || (Yii::$app->controller->module->databaseStorage !== false && Yii::$app->controller->module->webAccessUrl === false)){
				$this->_model = new StorageItem();
				$this->_model->mime_type = $this->file->type;
				$this->_model->file_path = $this->getFileName();
				if(!$this->_model->save()){
					return false;
				}
			}
            if(!$this->file->saveAs(Yii::$app->controller->module->getFilePath($this->getFileName()), true)){
				$this->_model->delete();
				return false;
			}
			return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        if (empty($this->errors)) {
			if(Yii::$app->controller->module->webAccessUrl === false){
				return [
					'filelink' => Url::to(['view', 'id' => $this->_model->id]),
					'filename' => $this->getFileName(),
				];
			}else{
				return [
					'filelink' => Yii::$app->controller->module->getUrl($this->getFileName()),
					'filename' => $this->getFileName(),
				];
			}
		}else{
			return [
				'error' => $this->errors,
			];
		}
    }

    /**
     * @return string
     */
    protected function getFileName()
    {
        if (!$this->_fileName) {
            $fileName = substr(uniqid(md5(rand()), true), 0, 10);
            $fileName .= '-' . Inflector::slug($this->file->baseName);
            $fileName .= '.' . $this->file->extension;
            $this->_fileName = $fileName;
        }
        return $this->_fileName;
    }
}
