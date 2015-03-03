/*
 Block Quote
 */

SirTrevor.Blocks.Quote = (function(){

    var template = _.template([
        '<div class="st-block-quote"><blockquote class="st-required st-text-block" contenteditable="true"></blockquote></div>',
    ].join("\n"));

    return SirTrevor.Block.extend({
        type: "quote",
        className: 'st-block st-icon--add st-quote',

        title: function(){ return i18n.t('blocks:quote:title'); },

        icon_name: 'quote',

        editorHTML: function() {
            return template(this);
        },

        loadData: function(data){
            this.getTextBlock().html(SirTrevor.toHTML(data.text, this.type));
            this.$('.js-cite-input').val(data.cite);
        },

        toMarkdown: function(markdown) {
            return markdown.replace(/^(.+)$/mg,"> $1");
        }

    });

})();