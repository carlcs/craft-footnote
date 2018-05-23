(function($R) {
    $R.add('plugin', 'footnotes', {
        init: function(app) {
            this.app = app;
            this.lang = app.lang;
            this.opts = app.opts;
            this.toolbar = app.toolbar;

            this.addAfter = this.opts.footnoteAddAfter || this.opts.footnoteaddafter || 'lists';
        },
        start: function() {
            var data = {
                title: Craft.t('footnotes', 'Footnote'),
                icon: Craft.Footnotes.icon,
                api: 'module.inline.format',
                args: {
                    tag: 'span',
                    class: 'fn-marker',
                    type: 'toggle',
                },
            };

            this.toolbar.addButtonAfter(this.addAfter, 'footnote', data);
        },
    });
})(Redactor);
