<?php

use backend\components\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var product\models\Order $model
 */?>

<div class="order view col-md-11 col-lg-11 column">
    <div class="row">
        <h4 class="pull-left title">Title</h4>
    </div>
    <div class="row">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1">
                    ID
                </th>
                <th class="col-md-2">
                    Summ price
                </th>
                <th class="col-md-2">
                    <span class="line"></span>
                    Phone
                </th>
                <th class="col-md-2">
                    <span class="line"></span>
                    Name
                </th>
                <th class="col-md-3">
                    <span class="line"></span>
                    Email
                </th>
                <th class="col-md-3">
                    <span class="line"></span>
                    Date Created
                </th>
            </tr>
            </thead>
            <tbody>
            <!-- row -->
            <tr class="first">
                <td>
                    #<?=$model->id?>
                </td>
                <td>
                    <?=$model->getSummaryCost()?>
                </td>
                <td>
                    <?=$model->profile->phone?>
                </td>
                <td>
                    <?=$model->profile->username?>
                </td>
                <td>
                    <?=$model->profile->email?>
                </td>
                <td>
                    <?=$model->date_created?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr/>

    <div class="row">
        <h4 class="pull-left title">Product</h4>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="col-md-1"></th>
                <th class="col-md-3">Title</th>
                <th class="col-md-3"><span class="line"></span>Price</th>
                <th class="col-md-3"><span class="line"></span>Count</th>
                <th class="col-md-3"><span class="line"></span>Summary Cost</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($model->values as $value):?>
                <tr class="first">
                    <td>
                        <div class="img">
                            <a href="<?Url::toRoute(['/product/product/update', 'id' => $value->product->id])?>">
                                <img src="<?=$value->product->getMainPhoto()->getUrlBySize('xsmall');?>" alt=""/>
                            </a>
                        </div>
                    </td>
                    <td>
                        <a href="<?Url::toRoute(['/product/product/update', 'id' => $value->product->id])?>" class="name">
                            <?=$value->product->title?>
                        </a>
                    </td>
                    <td><?=$value->product->price?></td>
                    <td><?=$value->count?></td>
                    <td><?=($value->product->price * $value->count)?></td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div
            class="col-md-10 column form-wrapper order">
            <?$form = \backend\components\TBSForm::begin([
                'action' => Url::toRoute(['/product/order/closed', 'id' => $model->id]),
            ]);?>
            <?=$form->field($model, 'description')->textarea()?>
            <?=\backend\components\Html::submitButton('Closed')?>
            <?\backend\components\TBSForm::end()?>
        </div>
    </div>
</div>

