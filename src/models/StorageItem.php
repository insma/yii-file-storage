<?php

/**
 * @link https://github.com/insma/yii2-file-storage
 * @copyright Copyright (c) 2015 Insma Software
 * @license https://github.com/insma/yii2-file-storage/wiki/LICENSE
 */

namespace insma\storage\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%storage_item}}".
 *
 * @author Maciej Klemarczyk <m.klemarczyk+dev@live.com>
 * @since 1.0
 *
 * @property string $id
 * @property string $mime_type
 * @property string $file_path
 * @property string $created_at
 * @property string $updated_at
 */
class StorageItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%storage_item}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mime_type', 'file_path'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['mime_type', 'file_path'], 'string', 'max' => 255],
            [['file_path'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mime_type' => Yii::t('app', 'Mime type'),
            'file_path' => Yii::t('app', 'File path'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }
}
