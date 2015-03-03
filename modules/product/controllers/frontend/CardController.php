<?php

namespace product\controllers\frontend;

use \frontend\components\Controller;
use product\models\Product;

class CardController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionAdd()
    {
        $productId  = \Y::post('product_id');

        $count      = \Y::post('count');
        if (empty($productId)) {
            $this->endJson('Empty product id');
        }
        /** @var \product\models\Product $product */
        if (!$product = Product::findOne(['id' => $productId])) {
            $this->endJson('Product not isset');
        }

        $result = (\Y::session()->get('card'))
            ? \Y::session()->get('card')
            : ['products' => [], 'summaryCost' => 0, 'summaryCount' => 0];

        $result['products'][$productId] = [
            'id'    => $productId,
            'img'   => ($img = $product->getMainPhoto())?$img->getUrlBySize('xsmall'):'http://placehold.it/80x80',
            'title' => $product->title,
            'price' => $product->price,
            'count' => $count,
        ];

        $summaryCost    = 0;
        $summaryCount   = 0;

        foreach ($result['products'] as $item) {
            $summaryCost    += ($item['price'] * $item['count']);
            $summaryCount++;
        }

        $result['summaryCost']  = $summaryCost;
        $result['summaryCount'] = $summaryCount;

        \Y::session()->set('card', $result);

        $this->endJson('ok', $result);
    }

    public function actionRemove()
    {
        $productId = \Y::post('product_id');
        if (empty($productId)) {
            $this->endJson('error', []);
        }
        $result = \Y::session()->get('card');

        if (isset($result['products'][$productId])) {
            unset($result['products'][$productId]);
        }

        $summaryCost    = 0;
        $summaryCount   = 0;

        foreach ($result['products'] as $item) {
            $summaryCost    += ($item['price'] * $item['count']);
            $summaryCount   += $item['count'];
        }

        $result['summaryCost']  = $summaryCost;
        $result['summaryCount'] = $summaryCount;




        \Y::session()->remove('card');

        \Y::session()->set('card', $result);

        $this->endJson('ok', $result);
    }

    public function actionClearCard()
    {
        \Y::session()->remove('card');
        $this->endJson('ok');
    }
}