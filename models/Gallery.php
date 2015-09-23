<?php

namespace wolfguard\gallery\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\log\Logger;
use Yii;

/**
 * Gallery ActiveRecord model.
 *
 * Database fields:
 * @property integer $id
 * @property string  $code
 * @property string  $name
 * @property string  $description
 * @property integer  $sort
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property GalleryImage[] $images
 *
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class Gallery extends ActiveRecord
{
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'code'          => \Yii::t('gallery', 'Code'),
            'name'          => \Yii::t('gallery', 'Name'),
            'description'   => \Yii::t('gallery', 'Description'),
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
        ];
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'create'   => ['name', 'code', 'description', 'sort'],
            'update'   => ['name', 'code', 'description', 'sort'],
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // code rules
            ['code', 'required', 'on' => ['create', 'update']],
            ['code', 'match', 'pattern' => '/^[0-9a-zA-Z\_\.\-]+$/'],
            ['code', 'string', 'min' => 3, 'max' => 255],
            ['code', 'unique'],
            ['code', 'trim'],

            // name rules
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'trim'],

            ['sort', 'integer'],
            ['sort', 'trim'],
        ];
    }

    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing object');
        }

        if ($this->save()) {
            \Yii::getLogger()->log('Gallery has been created', Logger::LEVEL_INFO);
            return true;
        }

        \Yii::getLogger()->log('An error occurred while creating gallery', Logger::LEVEL_ERROR);

        return false;
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%gallery}}';
    }

    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['gallery_id' => 'id']);
    }
}
