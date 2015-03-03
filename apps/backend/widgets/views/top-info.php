<?
/**
 * @var int $totalArticles
 * @var int $thisMonthArticle
 */
?>

<!-- upper main stats -->
<div id="main-stats">
    <div class="row stats-row">
        <div class="col-md-3 col-sm-3 stat">
            <div class="data">
                <span class="number"><?=_t('backend', '{0,number}', $totalArticles)?></span>
                articles
            </div>
            <span class="date">Total</span>
        </div>
        <div class="col-md-3 col-sm-3 stat">
            <div class="data">
                <span class="number"><?=_t('backend', '{0,number}', $thisMonthArticle)?></span>
                articles
            </div>
            <span class="date"><?=_t('backend', '{0, date, MMM YYYY}', strtotime(date('Y-m-01')))?></span>
        </div>
        <?if(false):?>
        <div class="col-md-3 col-sm-3 stat">
            <div class="data">
                <span class="number">322</span>
                orders
            </div>
            <span class="date">This week</span>
        </div>
        <div class="col-md-3 col-sm-3 stat last">
            <div class="data">
                <span class="number">$2,340</span>
                sales
            </div>
            <span class="date">last 30 days</span>
        </div>
        <?endif?>
    </div>
</div>
<!-- end upper main stats -->
