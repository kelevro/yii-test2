<?php
/** @var yii\web\View $this */
/** @var content\models\forms\BookForm $model */
/** @var \backend\components\TBSForm $form */

common\assets\Select2::register($this);

$authors = [];
foreach ($model->authors as $k => $v) {
    $authors[] = ['id' => $k, 'text' => $v];
}
$authors = \yii\helpers\Json::encode($authors);

$users = [];
foreach ($model->users as $k => $v) {
    $users[] = ['id' => $k, 'text' => $v];
}
$users = \yii\helpers\Json::encode($users);

$this->registerJs(<<<JS

$('.authorsTest').select2({
    placeholder: 'select authors',
    multiple: true,
    ajax: {
        url: '/content/author/search-ajax',
        dataType: 'json',
        quietMillis: 100,
        data: function (term) {
            return {q: term};
        },
        results: function (data) {
            return {results: data.data.authors};
        }
    }
}).select2('data', {$authors});

$('.usersTest').select2({
    placeholder: 'select users',
    multiple: true,
    ajax: {
        url: '/content/user/search-ajax',
        dataType: 'json',
        quietMillis: 100,
        data: function (term) {
            return {q: term};
        },
        results: function (data) {
            return {results: data.data.users};
        }
    }
}).select2('data', {$users});

JS
);
?>

<div class="row">
    <h4 class="pull-left title">Book</h4>
</div>

<div class="row">
<div class="col-md-10 column form-wrapper book">
<?$form = \backend\components\TBSForm::begin();?>

    <?=$form->field($model, 'title')->textInput(['id' => 'book-title'])?>
    <div class="row">
        <div class="col-md-10">
            <?=$form->field($model, 'slug')->textInput(['id' => 'book-slug'])?>
        </div>
        <div class="col-md-2">
            <a href="#" class="generate-slug"
               data-url="/site/generate-slug"
               data-max-length="50"
               data-slug-field="book-slug"
               data-title-field="book-title">
                generate
            </a>
        </div>
    </div>
    <?=$form->field($model, 'authorsText')
        ->textInput(['class' => 'authorsTest col-md-12', 'multiple' => 'multiple','value' => ''])?>
    <?=$form->field($model, 'usersText')
        ->textInput(['class' => 'usersTest col-md-12', 'multiple' => 'multiple','value' => ''])?>

<?=\backend\components\Html::submitButton('Save')?> or <?=\backend\components\Html::a('cancel', ['index'])?>

<?\backend\components\TBSForm::end()?>
</div>
</div>