<?php

namespace wolfguard\gallery\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\log\Logger;
use Yii;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * GalleryImage ActiveRecord model.
 *
 * Database fields:
 * @property integer $id
 * @property integer $gallery_id
 * @property string  $file
 * @property string  $alt
 * @property integer  $sort
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Gallery $gallery
 *
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 *
 * @mixin ImageUploadBehavior
 */
class GalleryImage extends ActiveRecord
{
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'gallery_id'    => \Yii::t('gallery', 'Gallery'),
            'file'          => \Yii::t('gallery', 'Image'),
            'alt'           => \Yii::t('gallery', 'Alt'),
            'sort'          => \Yii::t('gallery', 'Sort index'),
            'created_at'    => \Yii::t('gallery', 'Created at'),
            'updated_at'    => \Yii::t('gallery', 'Updated at'),
        ];
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => '\yiidreamteam\upload\ImageUploadBehavior',
                'attribute' => 'file',
                'thumbs' => [
                    'small' => ['width' => 100, 'height' => 100],
                ],
                'filePath' => '@webroot/upload/gallery/[[pk]]/[[basename]]',
                'fileUrl' => '/upload/gallery/[[pk]]/[[basename]]',
                'thumbPath' => '@webroot/upload/gallery/[[pk]]/[[profile]]_[[basename]]',
                'thumbUrl' => '/upload/gallery/[[pk]]/[[profile]]_[[basename]]',
            ],
        ];
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'create'   => ['gallery_id', 'file', 'alt', 'sort'],
            'update'   => ['gallery_id', 'file', 'alt', 'sort'],
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            ['gallery_id', 'required'],

            ['file', 'file', 'extensions' => 'jpg, gif, png'],

            ['sort', 'integer'],
            ['sort', 'trim'],

            ['alt', 'string', 'max' => 255],
            ['alt', 'trim'],
        ];
    }

    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing object');
        }

        if ($this->save()) {
            \Yii::getLogger()->log('Gallery image has been created', Logger::LEVEL_INFO);
            return true;
        }

        \Yii::getLogger()->log('An error occurred while creating gallery image', Logger::LEVEL_ERROR);

        return false;
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%gallery_image}}';
    }

    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }
}
