<?php
/** @var yii\web\View $this */
$searchUrl = "http://" . \Y::param('domains.frontend');
$this->registerJs(<<<JS
    $('.search-book-form').submit(function(e){
        e.preventDefault();

        $.getJSON('{$searchUrl}/books', {term: $('#term').val()})
            .done(function(response) {
                $('.json').html(JSON.stringify(response, null, 4));
            });
    });
JS
)

?>
<form action="" method="get" class="form-inline search-book-form" role="form">
    <div class="form-group">
        <input type="text" class="form-control search-book-form" name="term" id="term" placeholder="Input ...">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<details class="search-result" open>
    <summary>JSON DATA</summary>
    <pre class="json"></pre>
</details>
