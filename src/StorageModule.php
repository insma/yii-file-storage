<?php

/**
 * @link https://github.com/insma/yii2-file-storage
 * @copyright Copyright (c) 2015 Insma Software
 * @license https://github.com/insma/yii2-file-storage/wiki/LICENSE
 */

namespace insma\storage;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * @author Maciej Klemarczyk <m.klemarczyk+dev@live.com>
 * @since 1.0
 */
class StorageModule extends \yii\base\Module
{
    /**
     * @var string
     */
    public $localStorageDir = '@webroot/uploads';

    /**
     * @var string|false
     */
    public $webAccessUrl = '@web/uploads';

    /**
     * @var boolean|null
     */
    public $databaseStorage = null;

    /**
     * @var array|null
     */
    public $fileAllowedExtensions = null;

    /**
     * @inheritdoc
     */
	public function getControllerPath()
	{
		return 'insma\storage\controllers';
	}

    /**
     * @return string
     * @throws InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function getStorageDir()
    {
        $path = Yii::getAlias($this->localStorageDir);
        if (!file_exists($path) && !is_dir($path)) {
            throw new InvalidConfigException('Invalid config $localStorageDir. Directory not exist.');
        }
        if (!is_dir($path)) {
            throw new InvalidConfigException('Invalid config $localStorageDir. $localStorageDir is not a directory.');
        }
		return $path;
    }

    /**
     * @param $fileName
     * @return string
     * @throws InvalidConfigException
     */
    public function getFilePath($fileName)
    {
        return $this->getStorageDir() . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @param $fileName
     * @return string
     */
    public function getUrl($fileName)
    {
        if (!$this->webAccessUrl) {
            throw new InvalidConfigException('Invalid config $webAccessUrl. Web access is disabled.');
        }
        return Url::to($this->uploadUrl . '/' . $fileName);
    }
}
