<?php


namespace content\urls;

use yii\base\Exception;
use yii\web\UrlRule;
use content\models\Book;

/**
 * Content article url rule
 *
 * @package content\urls
 */
class BookRule extends UrlRule
{
    /**
     * @var string
     */
    public $urlPrefix = 'books/';


    /**
     * @var string
     */
    public $route = 'content/book/view';

    /**
     * @var string
     */
    public $urlSuffix = 'html';

    public function init()
    {}


    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params)
    {
        if ($this->route != $route) {
            return false;
        }

        if (empty($params['book'])) {
            throw new Exception("No required param 'book'");
        }

        if (is_numeric($params['bool'])) {
            $bookData = Book::find()
                ->select('id, slug')
                ->andWhere(['id' => $params['book']])
                ->asArray()
                ->one();
            if ($bookData == null) {
                throw new Exception("Book #{$params['book']} is not found");
            }
        } else if (is_array($params['book'])) {
            $bookData = $params['book'];
            if (empty($bookData['id']) || empty($bookData['slug'])) {
                throw new Exception('Book array must contains two elements: id, slug');
            }
        } else if ($params['book'] instanceof Book) {
            if ($params['book']->getIsNewRecord()) {
                throw new Exception('Book model instance must be saved');
            }
            $bookData = $params['book']->attributes;
        } else {
            throw new Exception("Unknown 'article' input param");
        }
        unset($params['book']);

        $url = 'b'.$bookData['id'].'-'.$bookData['slug'];

        if ($this->urlSuffix) {
            $url .= '.'.$this->urlSuffix;
        }

        if ($params) {
            $url .= '?' . http_build_query($params);
        }

        return $this->urlPrefix . $url;
    }


    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {
        if (($pi = $request->getPathInfo()) == null) {
            return false;
        }

        if ($this->urlPrefix && strpos($pi, $this->urlPrefix) !== 0) {
            return false;
        }

        $pi = substr($pi, strlen($this->urlPrefix));

        $sufx = $this->urlSuffix ? '\.'.$this->urlSuffix : null;
        if (!preg_match('/^b(\d+)-(.*)'.$sufx.'$/', $pi, $matches)) {
            return false;
        }
        $id = intval($matches[1]);

        $isBook = Book::find()->andWhere(['id' => $id])->exists();

        if (!$isBook) {
            return false;
        }


        return [$this->route, ['book' => $id]];
    }
}