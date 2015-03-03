<?php


namespace seo\widgets;

use seo\Exception;
use seo\widgets\assets\SeoDataAsset;
use yii\base\Model;
use yii\base\Widget;
use yii\widgets\ActiveForm;

/**
 * Widget for edit seo data in backend
 * @package seo\widgets
 */
class BackendSeoData extends Widget
{
    /**
     * @var Model
     */
    public $model;

    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * Check params
     */
    public function init()
    {
        if (!$this->model->getBehavior('seoData')) {
            throw new Exception('Model '.get_class($this->model).' must has SeoData behavior');
        }
    }


    /**
     * Render
     */
    public function run()
    {
        $seoClass = strtolower($this->model->seoData->formName());

        $this->form->beforeValidate = <<<TEXT
function (\$form, attribute, messages) {
    if (!\$(':checkbox.enable-seo').prop('checked') && attribute) {
        if (\$(attribute).attr('name').search('^{$seoClass}') === 0) {
            return false;
        }
    }
    return true;
}
TEXT;

        SeoDataAsset::register($this->view);
        echo $this->render('backend-seo-data', [
            'model'   => $this->model,
            'form'    => $this->form,
        ]);
    }
}