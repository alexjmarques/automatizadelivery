var link_site = $('body').attr('data-link_site');
var estado_site = $('body').attr('data-estado_site');
var formatter = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 2 });
jQuery.fn.shake = function(interval, distance, times) {
    interval = typeof interval == "undefined" ? 100 : interval;
    distance = typeof distance == "undefined" ? 10 : distance;
    times = typeof times == "undefined" ? 3 : times;
    var jTarget = $(this);
    jTarget.css('position', 'relative');
    for (var iter = 0; iter < (times + 1); iter++) { jTarget.animate({ left: ((iter % 2 == 0 ? distance : distance * -1)) }, interval); }
    return jTarget.animate({ left: 0 }, interval);
}


(function($) {

    var app = $.sammy('#app', function() {
        this.use('Template');

        this.around(function(callback) {
            var context = this;
            this.load('data/articles.json')
                .then(function(items) {
                    context.items = items;
                })
                .then(callback);
        });

        this.get('#/', function(context) {
            context.app.swap('');
            $.each(this.items, function(i, item) {
                context.render(`${link_site}/teste`, { id: i, item: item })
                    .appendTo(context.$element());
            });
        });

        this.get('#/about/', function(context) {
            var str = location.href.toLowerCase();
            context.app.swap('');
            context.render('templates/about.template', {})
                .appendTo(context.$element());
        });

        this.get('#/article/:id', function(context) {
            this.item = this.items[this.params['id']];
            if (!this.item) { return this.notFound(); }
            this.partial('templates/article-detail.template');
        });


        this.before('.*', function() {

            var hash = document.location.hash;
            $("nav").find("a").removeClass("current");
            $("nav").find("a[href='" + hash + "']").addClass("current");
        });

    });

    $(function() {
        app.run('#/');
    });

})(jQuery);



// $.routes.add('/news/{id:int}/', function() {
//     $('#news').load('news.php?id=' + this.id).show();
// });