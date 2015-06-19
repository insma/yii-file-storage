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
     * @inheritdoc
     */
	public function getControllerPath()
	{
		return 'insma\storage\controllers';
	}
}
