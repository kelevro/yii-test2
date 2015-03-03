SirTrevor.fileUploaderCustom = function(type, block, file, success, error) {

    SirTrevor.EventBus.trigger("onUploadStart");

    var uid  = [block.blockID, (new Date()).getTime(), 'raw'].join('-');
    var data = new FormData();

    data.append('attachment[name]', file.name);
    data.append('attachment[file]', file);
    data.append('attachment[uid]', uid);

    block.resetMessages();

    var callbackSuccess = function(data){
        SirTrevor.log('Upload callback called');
        SirTrevor.EventBus.trigger("onUploadStop");

        if (!_.isUndefined(success) && _.isFunction(success)) {
            _.bind(success, block)(data);
        }
    };

    var callbackError = function(jqXHR, status, errorThrown){
        SirTrevor.log('Upload callback error called');
        SirTrevor.EventBus.trigger("onUploadStop");

        if (!_.isUndefined(error) && _.isFunction(error)) {
            _.bind(error, block)(status);
        }
    };

    var url = type == 'mainImage' ? SirTrevor.DEFAULTS.mainImageUrl : SirTrevor.DEFAULTS.uploadUrl;
    var xhr = $.ajax({
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        type: 'POST'
    });

    block.addQueuedItem(uid, xhr);

    xhr.done(callbackSuccess)
        .fail(callbackError)
        .always(_.bind(block.removeQueuedItem, block, uid));

    return xhr;
};
SirTrevor.BlockMixins.Uploadable = {

    mixinName: "Uploadable",

    uploadsCount: 0,

    initializeUploadable: function() {
        SirTrevor.log("Adding uploadable to block " + this.blockID);
        this.withMixin(SirTrevor.BlockMixins.Ajaxable);

        this.upload_options = _.extend({}, SirTrevor.DEFAULTS.Block.upload_options, this.upload_options);
        this.$inputs.append(_.template(this.upload_options.html, this));
    },

    uploader: function(file, success, failure){
        return SirTrevor.fileUploader(this, file, success, failure);
    },

    uploaderCustom: function(type, file, success, failure){
        return SirTrevor.fileUploaderCustom(type, this, file, success, failure);
    }
};