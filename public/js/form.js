

$(document).ready(function () {
    const hdn_el = ['country_name', 'state_name', 'city_name']; 
    hide_elements(hdn_el);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('form').on('submit', function(el){
        el.preventDefault();
        $('.text-danger, #alert_msg').empty();
        var is_submittable = validate_before_submit();
        if(is_submittable){
            call_ajax(this, '/', 'POST', 'handle_submit',"multipart/form-data");
        }
    });

    $('form').on('reset', function(el){
        el.preventDefault();
        $('select').val('').trigger('change');
    });

    $('select').on('change', function(){
        $($(this).data('attr')).hide();
        $('#state, #city').show();
        if($(this).val() == '0'){
            $($(this).data('attr')).show();
            if($(this).attr('name') == 'country_code'){
                $('#state, #city').val(0).trigger('change');
                $('#state, #city').hide();
            }
            if($(this).attr('name') == 'state_code'){
                $('#city').val(0).trigger('change');
                $('#city').hide();
            }
        } else {
            if($(this).attr('name') == 'country_code'){
                call_ajax(this, '/state/'+$(this).val(), 'GET', 'reset_state_option',"multipart/form-data");
                $('#state, #city').val('').trigger('change');
            }
            if($(this).attr('name') == 'state_code'){
                call_ajax(this, '/city/'+$(this).val(), 'GET', 'reset_city_option',"multipart/form-data");
                $('#city').val('').trigger('change');
            }
        }
    });





    function hide_elements(collection=[]){
        $.each(collection, function (indexInArray, valueOfElement) { 
             $('[name="'+ valueOfElement +'"]').hide();
        });
    }

    function call_ajax(that, url, method, action_method, type="application/x-www-form-urlencoded"){
        let data = that;
        if($(data).length && method == 'POST'){
            data = new FormData($(that)[0]);
        }

        $.ajax({
            type: method,
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (typeof window[action_method] == "function") { 
                    window[action_method](response);
                }
            },
            error: function(err){
                if(err.status == 422){
                    display_error(err.responseJSON);
                }
            }
        });

    }

    

    
});

function display_error(data){
    
    $.each(data.errors, function (indexInArray, valueOfElement) { 
        $('#'+indexInArray+'-error').html(valueOfElement);
   });
}

function reset_state_option(data){
    $('#state').html(make_valid_options(data, 'Select State'));
}

function reset_city_option(data){
    $('#city').html(make_valid_options(data, 'Select City'));
}

function make_valid_options(data, default_option_name){
    var html = '<option value="">'+default_option_name+'</option>';
    $.each(data, function (indexInArray, valueOfElement) { 
        html += '<option value="'+valueOfElement['id']+'">'+valueOfElement['name']+'</option>';
    });
    html += '<option value="0">Other</option>';
    return html;
}

function handle_submit(data){
    if(data.error){
        $('#alert_msg').html('<div class="alert alert-danger" role="alert">'+data.error+'</div>');
    }
    if(data.success){
        $('#alert_msg').html('<div class="alert alert-success" role="alert">'+data.success+'</div>');
    }
    if(data.errors){
        display_error(data);
    } else if(data.data){
        var collection = data.data
        var html = '';
        $.each(collection, function (indexInArray, valueOfElement) { 
            html += '<tr><td><img src="'+data.path+'/'+valueOfElement['avatar']+'"/></td>';
            html += '<td>'+valueOfElement['name']+'</td>';
            html += '<td>'+valueOfElement['email']+'</td>';
            html += '<td>'+valueOfElement['mobile']+'</td>';
            html += '<td>'+valueOfElement['country']+'</td>';
            html += '<td>'+valueOfElement['state']+'</td>';
            html += '<td>'+valueOfElement['city']+'</td>';
            html += '<td>'+valueOfElement['created_at']+'</td></tr>';
        });
        
        $('tbody').append(html);
    }
    
}

function validate_before_submit(){
    var flag = true;
    const el_arr = [
        'full_name',
        'email',
        'mobile',
        'country_code',
        // 'country_name',
        'state_code',
        // 'state_name',
        'city_code',
        // 'city_name',
        'avatar'
    ];

    $.each(el_arr, function (indexInArray, valueOfElement) { 
        if(!$('[name="'+ valueOfElement +'"]').val().length){
            $('#'+valueOfElement+'-error').html('This field is required.');
            flag = false;
        }        
   });

   if($('[name="country_code"]').val() == '0' && !$('[name="country_name"]').val().length){
    $('#country_name-error').html('This field is required.');
    flag = false;
   }
   if($('[name="state_code"]').val() == '0' && !$('[name="state_name"]').val().length){
    $('#state_name-error').html('This field is required.');
    flag = false;
   }
   if($('[name="city_code"]').val() == '0' && !$('[name="city_name"]').val().length){
    $('#city_name-error').html('This field is required.');
    flag = false;
   }

   return flag;

}