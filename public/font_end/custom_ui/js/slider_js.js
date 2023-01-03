$(document).ready(function(){

    $(function(){

        var liCount = $('.slider li').length;
        var ulWidth = (liCount * 100);
        var liWidth = (100/liCount);
        var leftIncrement = (ulWidth/liCount);


        $('.slider').height($('.slider li img').height());
        $('.slider img').on('load', function(){
        $('.loader').fadeOut();
            $('.slider').height($(this).height());
        })

        $(window).resize(function() {
            $('.slider').css('height', $('.slider li img').height());
        });

        $('.slider ul').css('width', ulWidth + '%');
        $('.slider li').css('width', liWidth + '%');

        $('.slider').append(function() {
            $(this).append('<div class="navigator"></div>');
            $(this).prepend('<span class="cus_prev" style="font-size: 18px;"><i class="icon-copy fa fa-chevron-left" aria-hidden="true"></i></span><span class="cus_next" style="font-size: 18px;"><i class="icon-copy fa fa-chevron-right" aria-hidden="true"></i></span>');
            $(this).find('li').each(function(){
                $('.navigator').append('<span></span>');
            });
        });

      $('.slider').css('height', $('.slider li img').height());

        $('.navigator span:first-child').addClass('active');


        if(liCount > 2) {
            $('.slider ul').css('margin-left', -leftIncrement + '%');
            $('.slider ul li:last-child').prependTo('.slider ul');
        } else if(liCount == 1) {
            $('.slider span').css('display', 'none');
            $('.autoPlay').css('display', 'none');
        } else if(liCount == 1) {
            $('.slider .cus_prev').css('display', 'none');
        }

        function moveLeft() {
            $('.slider ul').animate({
                left : -leftIncrement + '%'
            }, 500, function(){
                $('.slider ul li:first-child').appendTo('.slider ul');
                $('.slider ul').css('left', '');

                if($('.navigator span').hasClass('active')) {

                    if($('.navigator span.active').is(':last-child')) {
                        $('span.active').removeClass('active');
                        $('.navigator span:first-child').addClass('active');
                    } else {
                        $('span.active').next().addClass('active');
                        $('span.active').prev().removeClass('active');
                    }
                }
            });
        }


        function moveRight() {
            $('.slider ul').animate({
                left : leftIncrement + '%'
            }, 500, function(){
                $('.slider ul li:last-child').prependTo('.slider ul');
                $('.slider ul').css('left', '');

                if($('.navigator span').hasClass('active')) {

                    if($('.navigator span.active').is(':first-child')) {
                        $('span.active').removeClass('active');
                        $('.navigator span:last-child').addClass('active');
                    } else {
                        $('span.active').prev().addClass('active');
                        $('span.active').next().removeClass('active');
                    }
                }
            });
        }

      if(liCount > 1) {
            invertalValue = setInterval(function() {
                moveLeft();
            }, 3000);
        }

        $('.cus_prev').click(function(){
            moveRight();
        });

        $('.cus_next').click(function(){
            moveLeft();
        });

    });

    /* Mamun khandaker */
});
