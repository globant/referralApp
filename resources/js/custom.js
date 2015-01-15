(function($) {
    $(document).ready(function() {
        $('body').on('click', '#logout-btn', function(e) {
            e.preventDefault();

            helper.disconnectServer();
        });
        
        $('#test-local-login').click(function() {
            helper.testLocalLogin();
        })

        $('#carousel').carousel({
            interval: 10000000
        });

        $('.switch').on('click',function(){
            $('#comp').toggle();
        });
        /* Crossbrowser Select look and feel */
        if($('.selectpicker').length > 0) {
            $('.selectpicker').selectpicker();
        }
       
    });

    var helper = (function() {
        var $loginBtn = $('#login-btn');
        var $logoutBtn = $('#logout-btn');

        return {
            testLocalLogin: function() {
               var email = $('#usr_email').val();
               var pass = $('#pass').val();
               var result = $('#local-login-result');
               var parameters = 'usr_email=' + email + '&pass=' + pass;
                $.ajax({
                    type: 'POST',
                    url: '/api/local-login',
                    dataType: 'json',
                    success: function(r) {
                        result.removeClass();
                        if (r && r.success) {
                            result.addClass('info');
                            result.html(r.message);
                        } else {
                            result.addClass('error');
                            result.html('Error');
                        }
                        
                    },
                    data: parameters,
                });
            },
            signInCallback: function(authResult) {
                if (authResult['access_token']) {
                    this.authResult = authResult;
                    helper.connectServer();
                } else if (authResult['error']) {
                    $loginBtn.css('position', 'static');
//                    console.log('There was an error: ' + authResult['error']);
                }
            },
            connectServer: function() {
                $.ajax({
                    type: 'POST',
                    url: '/api/login',
                    contentType: 'application/octet-stream; charset=utf-8',
                    dataType: 'json',
                    success: function(r) {
                        if (r && r.success) {
                            // Remove button just in case (or just because)
                            $loginBtn.remove();
                            $logoutBtn.fadeIn();
                        }
                    },
                    processData: false,
                    data: this.authResult.code
                });
            },
            disconnectServer: function() {
                $.ajax({
                    type: 'POST',
                    url: '/api/login/logout',
                    async: false,
                    dataType: 'json',
                    success: function(r) {
                        if (r && r.reload) {
                            window.location.reload();
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
        };
    })();    
})(jQuery);