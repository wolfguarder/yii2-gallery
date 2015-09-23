<?php

namespace wolfguard\gallery\models;

use wolfguard\gallery\helpers\ModuleTrait;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * GalleryImageSearch represents the model behind the search form about Gallery.
 */
class GalleryImageSearch extends Model
{
    use ModuleTrait;

    /**
     * @var integer
     */
    public $gallery_id;

    /**
     * @var string
     */
    public $alt;

    /**
     * @var string
     */
    public $sort;

    /**
     * @var integer
     */
    public $created_at;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gallery_id', 'created_at', 'sort'], 'integer'],
            [['alt', 'sort'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gallery_id' => \Yii::t('gallery', 'Gallery'),
            'alt' => \Yii::t('gallery', 'Alt'),
            'sort' => \Yii::t('gallery', 'Sort index'),
            'created_at' => \Yii::t('gallery', 'Created at'),
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->module->manager->createGalleryImageQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'gallery_id');
        $this->addCondition($query, 'alt', true);
        $this->addCondition($query, 'sort');
        $this->addCondition($query, 'created_at');

        return $dataProvider;
    }

    /**
     * @param $query
     * @param $attribute
     * @param bool $partialMatch
     */
    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }

        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
