<?
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var product\models\Order $order */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>

<head>
    <title>Seges-electronics</title>
    <style>

        * {
            font-family: arial, Arial, sans-serif;
        }

        table{
            text-align: center;
            border: 0 !important;
            padding: 0 !important;

        }
        td, p{
            margin: 0;
        }

        img{
            border: 0;
        }

        h1, h2, img {
            margin: 0;
            padding: 0;
        }
        body{
            margin: 0;
            padding: 0;
        }

    </style>
</head>

<body>



<table cellpadding="0" cellspacing="0" border="0" style="width: 840px;" width="640px">
    <tr style="height: 20px; background-color: #f5f5f5;">
        <td style="width: 20px;" rowspan="8"></td>
        <td style="width: 800px;"></td>
        <td style="width: 20px;" rowspan="8"></td>
    </tr>

    <tr style=" background-color: #333333;">
        <td style="width: 600px; color: #FFFFFF;">
            <p style="height: 15px;"></p>
            <img src="<?=Url::toRoute(['/'], true)?>/images/logo-white.png" alt="SEGES ELECTRONICS" style="margin-top: 15px;" />
            <p style="font-size: 20px; line-height: 24px; margin-top:20px; margin-bottom: 20px; color: #FFFFFF;">
                Ваш заказ принят. В ближайшее время с Вами свяжется наш менеджер.
            </p>
        </td>
    </tr>

    <tr>
        <td>
            <table style="width: 100%; background-color: rgb(248, 248, 248);">
                <tr style="height: 30px; background-color: #cecece;">
                   <td>Картинка</td><td>Название</td><td>Цена за шт.</td><td>Кол. шт</td><td>Итого:</td>
                </tr>
                <?foreach($order->values as $value):?>
                    <tr style="height: 30px;">
                        <td>
                            <?if($image = $value->product->getMainPhoto()):?>
                                <img src="<?=$image->getUrlBySize('small')?>"
                                     alt="<?=$image->alt?>" title="<?=$image->title?>">
                            <?else:?>
                                <img src="http://placehold.it/214x170" alt="" />
                            <?endif?>
                        </td>
                        <td><?=$value->product->title?></td>
                        <td>$&nbsp;<?=$value->product->price?></td>
                        <td><?=$value->count?></td>
                        <td>$&nbsp;<?=$value->getSummPrice()?></td>
                    </tr>
                <?endforeach?>
                <tr style="height: 30px;">
                    <td></td><td></td><td></td>
                    <td style="background-color: #fff91a;">Итого:</td>
                    <td style="background-color: #fff91a;">$&nbsp;<?=$order->getSummaryCost()?></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="height: 100px; text-align: justify; font-size: 14px; text-indent: 30px; line-height: 18px; padding: 10px;">

            <p>Если у Вас возникли вопросы, или Вы хотите что ни будь изменить в заказе, Вы сможете это сделать, когда с Вами свяжется наш менеджер.</p>


            <a href="<?=Url::toRoute(['/'], true)?>" style="text-decoration: none; margin-top:10px; cursor: pointer; line-height: 20px; float: right; text-indent: 0; font-size: 14px; background-color: #1da300; color: #fcfcfc; border-radius: 2px; padding: 4px 10px; display: inline;">
                Перейти на сайт
            </a>

            <a href="<?=Url::toRoute(['/'], true)?>catalog" style="text-decoration: none; margin-top:10px; margin-right:10px; cursor: pointer; line-height: 20px; float: right; text-indent: 0; font-size: 14px; background-color: #1da300; color: #fcfcfc; border-radius: 2px; padding: 4px 10px; display: inline;">
                Купить еще радиокомпоненты
            </a>
            <p style="clear: both;"></p>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
    <tr>
        <td style=" text-align: center; font-size: 16px; line-height: 20px; padding: 10px;">

            <p style="line-height: 30px; font-weight: 700;">Контакты:</p>
            <p>Тел./факс: +7 499 781-18-92</p>
            <p>Отдел продаж: - sale@seges-electronics.ru</p>
            <p>Тех. поддержка - micro@seges-electronics.ru	</p>
            <p>г. Москва, проспект Зеленый, дом 5/12,
                строение 6, офис 631Б</p>
        </td>
    </tr>

    <tr>
        <td style="height: 50px;background-color: #333333; text-align: center;">
            <a style="color: #fff; margin-right: 15px;" href="http://vk.com/club21235199">Мы в контакте</a>
            <a style="color: #fff; margin-right: 15px;" href="http://www.odnoklassniki.ru/profile/558229398745?st.cmd=userMain">Мы в обнокласниках</a>
            <a style="color: #fff; margin-right: 15px;" href="https://www.facebook.com/pages/Seges-electronics/655240777887844?skip_nax_wizard=true&ref_type">Мы на facebook</a>
        </td>

    </tr>

    <tr>
        <td style="background-color: #f5f5f5; height: 20px;" >
        </td>
    </tr>


</table>




</body>

</html>