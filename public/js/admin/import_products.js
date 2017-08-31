var import_form=function(form){
    var import_arrays=function(_token,arr,src){
        var index=0;
        $('.-progress_import').html('');
        $(arr).each(function(){
            var htis_index=index;
            var res_html_list='<li class="in_progress">';
            $(this).each(function(){
                res_html_list+=this+'-->';
            });
            res_html_list = res_html_list.substring(0,res_html_list.length-3);
            res_html_list+='</li>';
            $('.-progress_import').append(res_html_list);
            var this_arr=this;
            $.ajax({
                url: src,
                type: "POST",
                data: {
                    _token:_token,
                    json:this_arr,
                    action:'add_list'
                },
                cache: false,
                success: function success(response) {
                    try{
                        
                        $('.-progress_import li').eq(htis_index).removeClass('in_progress');
                        response = JSON.parse(response);
                        console.log(response);
                        if(response.error == '0'){
                            $('.-progress_import li').eq(htis_index).addClass('success');
                        }else{
                            $('.-progress_import li').eq(htis_index).addClass('error');
                            $('.-progress_import li').eq(htis_index).append(' <span>'+response.message+'</span>')
                        }
                    }catch(e){

                    }
                }
            });
            index++;
        });
    }
    var form_data=new FormData(form[0]);
    var _token=form.find('input[name=_token]').val();
    $.ajax({
        url: form.attr('action'),
        type: "POST",
        data: form_data,
        contentType: false,
        processData: false,
        cache: false,
        success: function success(response) {
            try{
                response = JSON.parse(response);
                if(response.error == '0'){
                    import_arrays(_token,response.data,form.attr('action'));
                }else{
                    alert(response.message);
                }
            }catch(e){
                
            }
        }
    });
}

$(document).ready(function(){
    $('.-form_import').submit(function(e){
        e.preventDefault();
        import_form($(this));
        return false;
    });
});

