/**
 * Created by zhanghui on 16/5/10.
 */
function opacityOut(){
    $('.page-header .notify').animate({
        opacity:0
    },1000,'swing', function(){
        opacityIn();
    })
}
function opacityIn(){
    $('.page-header .notify').animate({
        opacity:1
    },1000,'swing', function(){
        opacityOut();
    })
}
$(function(){
    $(document).on('click', '.page-header .notify', function(){
        location.href="/admin/order/index";
    });

    setInterval(function(){
        $.ajax(
            {
                url:'/admin/notify',
                dataType:'json',
                success:function(data){
                    $('.page-header .notify span').html(data[0]);
                    if(data[0] > 0){
                        $('.page-header .notify').removeClass('hidden');
                        var html = '<audio id="neworder-sound" autoplay="autoplay" height="100" width="100">';
                        html += '<source src="/static/sound/neworder.mp3" type="audio/mp3" />';
                        html += '</audio>';
                        $('#neworder-sound').remove();
                        $('body').prepend(html);
                    }
                    else{
                        $('.page-header .notify').addClass('hidden');
                    }
                }
            }
        );
    }, 20000);

    opacityOut();
});