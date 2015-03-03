<?php
namespace frontend\controllers;

use frontend\components\Controller;
use news\models\News;
use product\models\Category;
use product\models\Product;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * Site controller
 */
class SitemapController extends Controller
{

    public function actionIndex()
    {
        $charset    = 'UTF-8';
        $contentType = 'application/xml';

        $contentType .= '; charset=' . $charset;

        \Yii::$app->response->getHeaders()->set('Content-Type', $contentType);

        $news = News::find()->enabled()->all();
        $categoris = Category::find()->enabled()->minLvl(2)->maxLvl(2)->all();


        $dom = new \domDocument("1.0", "utf-8");

        $root = $dom->createElement("urlset");
        $root->setAttribute('xmlns', 'http://www.google.com/schemas/sitemap/0.84');

        $url = $dom->createElement("url");
        $url->appendChild($dom->createElement("loc", Url::toRoute(['/brands'], true)));
        $url->appendChild($dom->createElement("changefreq", 'daily'));
        $url->appendChild($dom->createElement("priority", '0.5'));
        $root->appendChild($url);

        $url = $dom->createElement("url");
        $url->appendChild($dom->createElement("loc", Url::toRoute(['/documentation'], true)));
        $url->appendChild($dom->createElement("changefreq", 'daily'));
        $url->appendChild($dom->createElement("priority", '0.5'));
        $root->appendChild($url);

        $url = $dom->createElement("url");
        $url->appendChild($dom->createElement("loc", Url::toRoute(['/catalog'], true)));
        $url->appendChild($dom->createElement("changefreq", 'daily'));
        $url->appendChild($dom->createElement("priority", '0.5'));
        $root->appendChild($url);

        foreach ($news as $new) {
            $url = $dom->createElement("url");
            $url->appendChild($dom->createElement("loc", Url::toRoute(['/news/default/view', 'new' => $new->id], true)));
            $url->appendChild($dom->createElement("changefreq", 'daily'));
            $url->appendChild($dom->createElement("priority", '0.5'));
            $root->appendChild($url);
        }

        $productModule = \Yii::$app->getModule('product');

        foreach ($categoris as $category) {
            $url = $dom->createElement("url");
            $url->appendChild($dom->createElement("loc", Url::toRoute(['/product/default/category', 'category' => $category->id], true)));
            $url->appendChild($dom->createElement("changefreq", 'daily'));
            $url->appendChild($dom->createElement("priority", '0.5'));
            $root->appendChild($url);
            $query = Product::find()->orderByPosition()->enabled()->categories($category->id)->active();
            $dp =  new ActiveDataProvider([
                'query' => $query,
                'key'   => 'id',
                'pagination' => [
                    'defaultPageSize'   => $productModule->params['pageSize'],
                    'pageSizeLimit'     => [1, $productModule->params['pageSize']],
                ],
            ]);
            $dp->prepare(false);
            $pageCount = $dp->pagination->pageCount;
            if ($pageCount > 1) {
                for ($i = 2; $i <= $pageCount; $i++) {
                    $url = $dom->createElement("url");
                    $url->appendChild($dom->createElement("loc", Url::toRoute(['/product/default/category', 'category' => $category->id, 'page' => $i], true)));
                    $url->appendChild($dom->createElement("changefreq", 'daily'));
                    $url->appendChild($dom->createElement("priority", '0.5'));
                    $root->appendChild($url);
                }
            }
        }


        $dom->appendChild($root);


        \Yii::$app->response->content = $dom->saveXML();
        \Yii::$app->response->send();
    }
}
