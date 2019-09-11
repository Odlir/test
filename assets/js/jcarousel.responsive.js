(function($) {
    $(function() {
        var jcarousel = $('.jcarousel');

        jcarousel
        // Bind _before_ carousel initialization
            .on('jcarousel:targetin', 'li', function() {
                $(this).addClass('active');
            })
            .on('jcarousel:targetout', 'li', function() {
                $(this).removeClass('active');
            })
            .jcarousel({
                // center: true,
                wrap: 'circular'
            });

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselPagination({
                perPage: 1,
                item: function(page) {
                    return '<a href="#' + page + '">' + page + '</a>';
                }
            });
    });
})(jQuery);
