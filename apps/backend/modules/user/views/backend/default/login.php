<?
/** @var \backend\models\LoginForm $model */
/** @var \yii\widgets\ActiveForm $form */
$form = \yii\widgets\ActiveForm::begin(['options' => ['class' => 'form-signin'],
           'fieldConfig' => ['template' => "{input}\n{error}"]])
?>
<div class="login-wrapper">
    <a href="/" class="logo-text">Yii test</a>

    <div class="box">
        <div class="content-wrap">
            <?=$form->field($model, 'email')->textInput(['class' => 'form-control', 'required' => 'required', 'autofocus' => 'autofocus',
                                                        'placeholder' => 'Email address'])?>

            <?=$form->field($model, 'password')->passwordInput(['class' => 'form-control', 'required' => 'required','placeholder' => 'Password'])?>

            <?=\yii\helpers\Html::submitButton('Sing in', ['class' => 'btn-glow primary login'])?>
        </div>
    </div>
</div>
<?\yii\widgets\ActiveForm::end() ?>