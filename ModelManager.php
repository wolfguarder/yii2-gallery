<?php

namespace wolfguard\gallery;

use yii\base\Component;

/**
 * ModelManager is used in order to create models and find galleries.
 *
 * @method models\Gallery               createGallery
 * @method models\GallerySearch         createGallerySearch
 *
 * @method models\GalleryImage               createGalleryImage
 * @method models\GalleryImageSearch         createGalleryImageSearch
 *
 * @author Ivan Fedyaev <ivan.fedyaev@gmail.com>
 */
class ModelManager extends Component
{
    /** @var string */
    public $galleryClass = 'wolfguard\gallery\models\Gallery';

    /** @var string */
    public $gallerySearchClass = 'wolfguard\gallery\models\GallerySearch';

    /** @var string */
    public $galleryImageClass = 'wolfguard\gallery\models\GalleryImage';

    /** @var string */
    public $galleryImageSearchClass = 'wolfguard\gallery\models\GalleryImageSearch';

    /**
     * Finds a gallery by the given id.
     *
     * @param  integer $id Gallery id to be used on search.
     * @return models\Gallery
     */
    public function findGalleryById($id)
    {
        return $this->findGallery(['id' => $id])->one();
    }

    /**
     * Finds a gallery image by the given id.
     *
     * @param  integer $id GalleryImage id to be used on search.
     * @return models\GalleryImage
     */
    public function findGalleryImageById($id)
    {
        return $this->findGalleryImage(['id' => $id])->one();
    }

    /**
     * Finds a gallery by the given code.
     *
     * @param  string $code Code to be used on search.
     * @return models\Gallery
     */
    public function findGalleryByCode($code)
    {
        return $this->findGallery(['code' => $code])->one();
    }

    /**
     * Finds a gallery by the given condition.
     *
     * @param  mixed $condition Condition to be used on search.
     * @return \yii\db\ActiveQuery
     */
    public function findGallery($condition)
    {
        return $this->createGalleryQuery()->where($condition);
    }

    /**
     * Finds a gallery image by the given condition.
     *
     * @param  mixed $condition Condition to be used on search.
     * @return \yii\db\ActiveQuery
     */
    public function findGalleryImage($condition)
    {
        return $this->createGalleryImageQuery()->where($condition);
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed|object
     */
    public function __call($name, $params)
    {
        $property = (false !== ($query = strpos($name, 'Query'))) ? mb_substr($name, 6, -5) : mb_substr($name, 6);
        $property = lcfirst($property) . 'Class';
        if ($query) {
            return forward_static_call([$this->$property, 'find']);
        }
        if (isset($this->$property)) {
            $config = [];
            if (isset($params[0]) && is_array($params[0])) {
                $config = $params[0];
            }
            $config['class'] = $this->$property;
            return \Yii::createObject($config);
        }

        return parent::__call($name, $params);
    }
}