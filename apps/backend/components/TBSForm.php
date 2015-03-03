<?php


namespace backend\components;

use yii\widgets\ActiveForm;

class TBSForm extends ActiveForm
{
    public $fieldConfig = [
        'template' =>  '{label}
                            <div class="col-md-9">
                                {input}
                                <span class="alert-msg"><i class="fa fa-times-circle"></i> {error}</span>
                                {hint}
                            </div>
                            ',
        'errorOptions' => ['tag' => 'span', 'class' => 'emr'],
        'options' => ['class' => 'field-box'],
    ];

    public function init()
    {
        $this->fieldConfig['class'] = TBSField::className();

        parent::init();
    }
}