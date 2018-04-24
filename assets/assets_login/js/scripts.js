
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch([
                    base_url+"assets/assets_login/img/backgrounds/2.jpg"
	              , base_url+"assets/assets_login/img/backgrounds/3.jpg"
	              , base_url+"assets/assets_login/img/backgrounds/1.jpg"
	             ], {duration: 3000, fade: 750});
    
    /*
        Form validation
     */
    $('#login-form').validate({
        rules : {
            level : {
                required : true
            },
            formusername : {
                required : true
            },
            formpassword : {
                required : true
            }
        },
        messages: {
            formusername: {
                required : 'field ini harus diisi',
            },
            formpassword: {
                required : 'field ini harus diisi'
            }
        }
    });
    
    // $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    // 	$(this).removeClass('input-error');
    // });
    
    // $('.login-form').on('submit', function(e) {
    	
    // 	$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
    // 		if( $(this).val() == "" ) {
    // 			e.preventDefault();
    // 			$(this).addClass('input-error');
    // 		}
    // 		else {
    // 			$(this).removeClass('input-error');
    // 		}
    // 	});
    	
    // });
    
    
});
