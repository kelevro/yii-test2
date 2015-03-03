<?php
namespace frontend\controllers;

use frontend\components\Controller;
use product\models\Product;
use yii\base\Exception;

/**
 * Site controller
 */
class EFindController extends Controller
{
    public $layout = false;

    public $log = 'e-find';

    public function actionIndex()
    {
        try {
            $charset = 'UTF-8';
            $contentType = 'application/xml';

            $contentType .= '; charset=' . $charset;

            \Yii::$app->response->getHeaders()->set('Content-Type', $contentType);

            $products = Product::find()
                ->active()
                ->enabled()
                ->andWhere(
                    'title LIKE :search OR description LIKE :search OR producer LIKE :search',
                    [':search' => '%' . \Y::get('search') . '%']
                )->limit(20)
                ->all();

            if (!$products) {
                return null;
            }

            $dom = new \domDocument("1.0", "utf-8");
            $root = $dom->createElement("data");


            /** @var Product $product */
            foreach ($products as $product) {
                $docs = $product->findRelatedDocumentations();
                $docLink = '';

                if($docs) {
                    $doc        = array_shift($docs);
                    $docLink    = \common\helpers\Storage::getStorageUrlTo('documentation') . '/' . $doc->link;
                }

                /** @var Product  $product */
                $line = $dom->createElement("line");
                $line->appendChild($dom->createElement("part", $product->title));
                $line->appendChild($dom->createElement("note", strip_tags($product->description)));
                $line->appendChild($dom->createElement("mfg", $product->producer));
                if ($docLink) {
                    $line->appendChild($dom->createElement("pdf", htmlentities($docLink)));
                }
                $line->appendChild($dom->createElement("cur", 'USD'));
                $line->appendChild($dom->createElement("p1", $product->price));
                $line->appendChild($dom->createElement("p2", $product->small_wholesale));
                $line->appendChild($dom->createElement("p3", $product->wholesale));
                $line->appendChild($dom->createElement("stock", ($product->count)?:'Нет'));
                $line->appendChild($dom->createElement("instock", 1));
                $root->appendChild($line);

            }
            $dom->appendChild($root);


            \Yii::$app->response->content = $dom->saveXML();
            \Yii::$app->response->send();
        } catch (Exception $e) {
            \L::trace($e->getMessage(), $this->log);
            \L::trace($e->getTraceAsString(), $this->log);
        }
    }
}
