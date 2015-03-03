<?
use frontend\themes\base\assets\BaseAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use mail\widgets\Subscribe;
use product\widgets\Search;

/**
 * @var $this \yii\web\View
 * @var $content string
 */
BaseAsset::register($this);
$this->registerJs(<<<JS
$('a[href^="#"]').click(function(){
    var target = $(this).attr('href');
    $('html, body').animate({scrollTop: $(target).offset().top}, 400);
    return false;
});
JS
);
?>
<?$this->beginPage()?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=Yii::$app->charset?>"/>
    <meta http-equiv="Content-Language" content="<?=\Yii::$app->language?>"/>

    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,400,700&subset=latin,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>

    <meta name="og:site_name" content="<?=\Y::param('public.siteName')?>"/>

    <title><?=Html::encode($this->title)?></title>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter25106627 = new Ya.Metrika({id:25106627,
                        webvisor:true,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true});
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="//mc.yandex.ru/watch/25106627" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->



    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-51413000-1', 'seges-electronics.ru');
        ga('send', 'pageview');

    </script>
    <?$this->head()?>
</head>
<body>

<?php $this->beginBody() ?>
<?=Subscribe::widget()?>
<div class="conteiner" align="center">
    <!-- Меню -->
    <!-- Верхняя часть-->
    <a href="#up"><div class="up">↑</div></a>
    <div class="menutop" id="up">
        <a href="https://www.facebook.com/groups/152129844991445/" target="_blank">
            <div style="margin-left: 40px" class="fs"></div>
        </a>
        <a href="mailto:micro@rk-electronics.ru">
            <div class="mails"></div>
        </a>
        <?=Search::widget()?>
        <a href="#"><div class="subscription subscribe-button">ПОДПИСКА НА НОВОСТИ</div></a>
    </div>
    <!-- Верхняя часть конец-->
    <!-- Нижняя часть -->
    <div class="menubottom">
    <a href="<?=Url::home()?>"><div class="logo"></div></a>
        <ul>
            <li></li>
            <li><a href="<?=Url::toRoute(['/news/default/index'])?>"><div class="menubutton">НОВОСТИ / СТАТЬИ</div></a></li>
            <li><a href="/catalog"><div class="menubutton">ПРОДУКЦИЯ</div></a></li>
            <li><a href="<?=Url::toRoute(['/product/default/category', 'category' => 58])?>"><div class="menubutton">УСТРОЙСТВА INTEGRAL</div></a></li>
            <li><a href="<?=Url::to(['/statical/page/view', 'alias' => 'brands'])?>"><div class="menubutton">ПРЕДСТАВЛЕННЫЕ БРЕНДЫ</div></a></li>
            <li><a href="<?=Url::to(['/statical/page/view', 'alias' => 'contacts'])?>"><div class="menubutton">КОНТАКТЫ</div></a></li>
            <li><a href="#"><div class="menubuttonlast"><?=\product\widgets\Card::widget()?></div></a></li>
            <?if(false):?>
                <li><a href="/documentation"><div class="menubutton">ТЕХ. ДОКУМЕНТАЦИЯ</div></a></li>
            <?endif?>
        </ul>
    </div>
    <!-- Нижняя часть конец -->
    <!-- Меню конец -->
    <div class="flash-message">
        <?= \frontend\widgets\Flash::widget() ?>
    </div>
    <?= $content ?>
    <div class="footerback"></div>
</div>
<div class="footer" align="center">
    <!-- Иконки соц. сетей -->
    <div class="iconconteiner">
        <a href="mailto:micro@rk-electronics.ru">
            <div class="mail"></div>
        </a>
        <a href="https://www.facebook.com/groups/152129844991445/" target="_blank">
            <div class="f"></div>
        </a>
    </div>
    <!-- Иконки соц. сетей  конец -->
    <!-- Нижнее меню -->
    <div class="nav-bottom">
        <ul>
            <li><a href="<?=Url::to(['/statical/page/view', 'alias' => 'about_company'])?>">О КОМПАНИИ</a></li>
            <li><a href="<?=Url::to(['/statical/page/view', 'alias' => 'partners'])?>">ПАРТНЕРАМ</a></li>
            <li><a href="<?=Url::toRoute(['/news/default/index'])?>">НОВОСТИ</a></li>
        </ul>
        <img src="/images/logos.png" alt="logos"/>
    </div>
    <!-- Нижнее меню конец -->
</div>
<?//if(\Y::hasAccess('seo')):?>
    <?//\seo\widgets\SeoData::widget()?>
<?//endif?>
<?//=\frontend\tracking\TrackingWidget::widget()?>
<?$this->endBody()?>
</body>
</html>
<?$this->endPage()?>