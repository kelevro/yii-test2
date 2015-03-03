<?php

namespace product\search;

use product\models\AttributeValue;
use product\models\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Searcher extends Model
{

    /** @var  \common\base\ActiveQuery */
    protected $query;


    public function search(UserSearch $us)
    {
        $this->query = Product::find()->orderByPosition()->enabled()->categories($us->category)->active();

        if ($us->filters) {
            foreach ($us->filters as $attrId => $filter) {
                $this->query->innerJoin(AttributeValue::tableName() . " atp{$attrId}", "atp{$attrId}.product_id = product.id");
                $this->query->andWhere(["atp{$attrId}.attribute_id" => $attrId, "atp{$attrId}.filter" => $filter]);
            }
        }

        $dp =  new ActiveDataProvider([
            'query' => $this->query,
            'key'   => 'id',
            'pagination' => [
                'defaultPageSize'   => $us->pageSize,
                'pageSizeLimit'     => [1, $us->pageSize],
                'page'              => $us->page
            ],
        ]);

        return $dp;
    }

    public function generalSearch(GeneralSearch $gs)
    {
        $this->query = Product::find()->enabled()->titleLike($gs->s)->active();

        $dp =  new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => [
                'defaultPageSize'   => $gs->pageSize,
                'pageSizeLimit'     => [1, $gs->pageSize],
                'page'              => $gs->page
            ],
        ]);

        return $dp;
    }



}