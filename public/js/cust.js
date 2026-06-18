$(document).ready(function(){
    /* if($(window).width() < 768){
        $('.projectsdetails .leftarrow').insertAfter($(this).parents('.projectsdetails').find('.project-name p'));
    } */
    var path = window.location.origin;

    if($(window).width() < 768){
        $('.projectsdetails').each(function () { 
            const button = $(this).find('.project-name p');
            console.log(button);
            
            $(this).find('.leftarrow').insertAfter(button);
        });
    }

    $('.menuIcon a').click(function(){
        $('.sidebar-left').slideToggle(200);
        if($(this).children('img').attr('src') == 'images/menu.png'){
            $(this).children('img').attr('src',path + '/images/close.png');
        }else{
            $(this).children('img').attr('src',path +'/images/menu.png');
        }
    });

    $('.sidebar-details ul li a').click(function(){
        if($(window).width() < 1025){
            $('.sidebar-left').hide(200);
        }
        $('.menuIcon a').children('img').attr('src',path + '/images/menu.png');
    });

    
    
    $('.chatbox-body').animate({ 
        scrollTop: $('.chatbox-inner').height() 
    }, 100);

    
    
});

