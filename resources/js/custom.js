(function($) {
    $(document).ready(function() {
        $('body').on('click', '#logout-btn', function(e) {
            e.preventDefault();

            helper.disconnectServer();
        });
    });

    var helper = (function() {
        var $loginBtn = $('#login-btn');
        var $logoutBtn = $('#logout-btn');

        return {
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

    window.signInCallback = function(authResult) {
        helper.signInCallback(authResult);
    };
})(jQuery);