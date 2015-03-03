<?php


namespace product\urls;

use yii\base\Exception;
use product\models\Product;
use yii\caching\GroupDependency;
use yii\web\UrlRule;

/**
 * Content product url rule
 *
 * @package product\urls
 */
class ProductRule extends UrlRule
{
    /**
     * @var string
     */
    public $urlPrefix = 'catalog/';


    /**
     * @var string
     */
    public $route = 'product/default/view';

    /**
     * Route for redirect
     * for case when product id has new slug
     *
     * @var string
     */
    public $redirectRoute = 'product/default/product-redirect';

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

        if (empty($params['product'])) {
            throw new Exception("No required param 'product'");
        }

        if (is_numeric($params['product'])) { // product by id
            $productData = Product::find()
                ->select('id, slug')
                ->andWhere(['id' => $params['product']])
                ->asArray()
                ->one();
            if ($productData == null) {
                throw new Exception("Product #{$params['product']} is not found");
            }
        } else if (is_array($params['product'])) { // product id
            $productData = $params['product'];
            if (empty($productData['id']) || empty($productData['slug'])) {
                throw new Exception('Product array must has two elements: id, slug');
            }
        } else if ($params['product'] instanceof Product) { // product model
            if ($params['product']->getIsNewRecord()) {
                throw new Exception('Product model instance must be saved');
            }
            $productData = $params['product']->attributes;
        } else {
            throw new Exception("Unknown 'product' input param");
        }
        unset($params['product']);

        $url = 'p'.$productData['id'].'-'.$productData['slug'];
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
        if (!preg_match('/^p(\d+)-(.*)'.$sufx.'$/', $pi, $matches)) {
            return false;
        }
        $id = intval($matches[1]);
        $slug = $matches[2];

        $product = Product::find()
            ->select('slug')
            ->andWhere(['id' => $id])
            ->asArray()
            ->one();

        if (!$product) {
            return false;
        }

        if ($slug != $product['slug']) {
            return [$this->redirectRoute, ['product' => $id]];
        }

        return [$this->route, ['product' => $id]];
    }
}