/**
 * Created by zhanghui on 16/5/10.
 */
function delegateEvent(){
    $(document).on('click', '.print', function(){
        var dom = $(this).parents('td').prev('td');
        print(dom);
    });
    $(document).on('click', '.nav-tabs li', function(){
        if(!$(this).hasClass('active')){
            $('.nav-tabs li').removeClass('active');
            $(this).addClass('active');
            var status = $(this).attr('data-status');
            $('#status').val(status);
            if(1 == status){
                $('form').submit();
            }else{
                location.href = '/admin/order/index';
            }

        }
    });
    $(document).on('click', 'button.deal a', function(){
        deal($(this).attr('data-id'),$(this).parents('tr'));
    });
}
function deal(id,obj){
    $.ajax({
        url:'/admin/order/deal',
        type:'POST',
        dataType:'JSON',
        data:{
            id:id
        },
        success:function(data,err){
            if(data.code == 0){
                $(obj).remove();
            }
        },
        error:function(err){
            form_error()
        }
    });
}
function print(dom){
    var copy = dom.clone();
    var number = dom.siblings('td').eq(0).html();
    copy.prepend('<p>编号:' + number + '</p>');
    var amount = dom.siblings('td').eq(1).html();
    copy.append('<p style="font-weight:bold;">合计:' + amount + '</p>');
    copy.find('p').css('font-size', '9pt');
    var header = '<p style="text-align:center;font-size:10pt;font-weight:bold;">小小家一生活助手</p>';
    copy.prepend(header);
    var LODOP = getLodop();
    LODOP.PRINT_INIT('');
    LODOP.SET_PRINT_PAGESIZE(3, 580, 200, '');
    LODOP.ADD_PRINT_HTM(0,0,"100%","100%",copy.html());
    //LODOP.SET_PRINT_COPIES(1);
    LODOP.PRINT();
}

$(function(){
    delegateEvent();
});