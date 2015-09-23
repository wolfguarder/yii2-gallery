<?php

namespace wolfguard\gallery\models;

use wolfguard\gallery\helpers\ModuleTrait;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * GallerySearch represents the model behind the search form about Gallery.
 */
class GallerySearch extends Model
{
    use ModuleTrait;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $code;

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
            [['created_at', 'sort'], 'integer'],
            [['name', 'code', 'sort'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('gallery', 'Name'),
            'code' => \Yii::t('gallery', 'Code'),
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
        $query = $this->module->manager->createGalleryQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'name', true);
        $this->addCondition($query, 'code', true);
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
