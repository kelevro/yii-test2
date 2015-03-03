/*
 Simple Image Block
 */

SirTrevor.Blocks.Mainimage = SirTrevor.Block.extend({

    type: "mainimage",
    title: function(){ return "Main Image"; },
    editorHTML: '<div class="st-block-image st-block-main-image"></div>',

    droppable: true,
    uploadable: true,

    icon_name: 'image',

    loadData: function(data) {

        // Create our image tag
        this.$editor.html($('<img>', { src: data.file.url }));
    },

    onBlockRender: function(){
        /* Setup the upload button */
        this.$inputs.find('button').bind('click', function(ev){ ev.preventDefault(); });
        this.$inputs.find('input').on('change', _.bind(function(ev) {
            this.onDrop(ev.currentTarget);
        }, this));
    },

    onDrop: function(transferData) {
        var file = transferData.files[0],
            urlAPI = (typeof URL !== "undefined") ? URL : (typeof webkitURL !== "undefined") ? webkitURL : null;


        // Handle one upload at a time
        if (/image/.test(file.type)) {
            this.loading();
            // Show this image on here
            this.$inputs.hide();
            var src = urlAPI.createObjectURL(file);
            this.$editor.html($('<img>', { src: src })).show();

            // Upload!
            SirTrevor.EventBus.trigger('setSubmitButton', ['Please wait...']);
            this.uploaderCustom(
                'mainImage',
                file,
                function(data) {
                    console.log(data);
                    $('#' + this.blockID + ' img')
                        .attr('src', data['src'])
                        .css('width', 'inherit')
                        .closest("div")
                            .css('text-align', 'center')
                    ;
                    this.setData(data);
                    this.ready();
                },
                function(error) {
                    console.log(error);
                    this.addMessage(i18n.t('blocks:image:upload_error'));
                    this.ready();
                }
            );
        }
    }
});

