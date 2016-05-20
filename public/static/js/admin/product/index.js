/**
 * Created by Administrator on 2016/5/11 0011.
 */
$(function(){
    $(document).on('click','input',function(){
        $(this).attr('readonly',false);
    });
    $(document).on('blur','input',function(){
        $(this).attr('readonly',true);
        var id    = $(this).closest('tr').attr('data-id');
        var stock = $(this).val();
        changeStock(id,stock,$(this));
    });
});

function changeStock(id,stock,e){
    $.ajax({
        url:'/admin/product/changeStock',
        type:'POST',
        dataType:'JSON',
        data:{
            id:id,
            stock:stock
        },
        success:function(data,err){
            if(data.code == 0){
                $(e).val(stock);
            }
        },
        error:function(err){
            form_error()
        }
    });
}