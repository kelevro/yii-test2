<?php

use backend\components\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \product\models\Category[] $categories */
?>

<div class="table-wrapper">
    <div class="row filter-block">
        <h4 class="pull-left">Categories</h4>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1">
                    ID
                </th>
                <th class="col-md-4">
                    <span class="line"></span>
                    Title
                </th>
                <th class="col-md-2">
                    <span class="line"></span>
                    Alias
                </th>
                <th class="col-md-2"><span class="line"></span></th>
            </tr>
            </thead>
            <tbody>
            <?foreach($categories as $category):?>
                <tr>
                    <td>
                        <?=$category->id?>
                        <?if($category->is_enabled):?><span class="label label-success" title="Published">A</span><?endif?>
                    </td>
                    <td>
                        <?=str_repeat(' - ', $category->lvl - 1)?> <?=Html::a($category->title, ['update', 'id' => $category->id])?>
                    </td>
                    <td><?= Html::a($category->slug)?></td>
                    <td>
                        <?if($category->lvl == 1):?>
                            <a href="<?=Url::toRoute(['/product/category/update', 'pid' => $category->id])?>">
                                <i class="fa fa-plus-square"></i>
                            </a>
                        <?endif?>
                        <?if($category->lvl > 1):?>
                            <a href="<?=Url::toRoute(['/product/category/up', 'id' => $category->id])?>">
                                <i class="fa fa-arrow-up"></i>
                            </a>
                            <a href="<?=Url::toRoute(['/product/category/down', 'id' => $category->id])?>">
                                <i class="fa fa-arrow-down"></i>
                            </a>
                        <?endif?>
                    </td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    </div>
</div>