<?php

namespace product\widgets;

use product\search\GeneralSearch;
use product\search\SearchQuery;
use yii\base\Widget;
use \product\assets\FiltersAsset;
use product\models\Category;
use product\search\UserSearch;

/**
 * Widget with index product as tiles
 *
 * @package product\widgets
 */
class Search extends Widget
{
    public function run()
    {
        if ($hash = \Y::get('h')) {
            $sq = SearchQuery::findOne(['hash' => $hash]);
            $gs = unserialize($sq->data);
        } else {
            $gs = new GeneralSearch();
        }
        return $this->render('search', [
            'gs' => $gs,
        ]);
    }
}