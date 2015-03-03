yii.formSubmitter = (function ($) {
    var pub = {
        // whether this module is currently active. If false, init() will not be called for this module
        // it will also not be called for all its child modules. If this property is undefined, it means true.
        isActive: true,
        init: function () {
            initDataMethod();
        },
        handleAction: function ($e) {
            var actionUrl = $e.data('action');
            if (actionUrl === undefined) {
                return true;
            }

            var $form = $e.closest('form');
            if ($form.length) {
                $form.attr('action', actionUrl);
            } else {
                return true;
            }

            var activeFormData = $form.data('yiiActiveForm');
            if (activeFormData) {
                // remember who triggers the form submission. This is used by yii.activeForm.js
                activeFormData.submitObject = $e;
            }

            $form.trigger('submit');

            return false;
        }
    };

    function initDataMethod()
    {
        var $document = $(document);
        // handle data-confirm and data-method for clickable elements
        $document.on('click.yii', yii.clickableSelector, function (event) {
            var $this = $(this);
            if (yii.allowAction($this)) {
                return pub.handleAction($this);
            } else {
                event.stopImmediatePropagation();
                return false;
            }
        });
    }

    return pub;
})(jQuery);


jQuery(document).ready(function () {
    yii.initModule(yii.formSubmitter);
});
