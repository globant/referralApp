(function($) {
    $(document).ready(function() {
        $('body').on('click', '#logout-btn', function(e) {
            e.preventDefault();

            helper.disconnectServer();
        });
    });

    var helper = (function() {
      var $loginBtn = $('#login-btn');

      return {
        /**
         * Hides the sign-in button and connects the server-side app after
         * the user successfully signs in.
         *
         * @param {Object} authResult An Object which contains the access token and
         *   other authentication information.
         */
        signInCallback: function(authResult) {
            if (authResult['access_token']) {
                this.authResult = authResult;
                helper.connectServer();
            } else if (authResult['error']) {
                $loginBtn.css('position', 'static');
                console.log('There was an error: ' + authResult['error']);
            }
        },
        connectServer: function() {
            $.ajax({
                type: 'POST',
                url: '/api/login',
                contentType: 'application/octet-stream; charset=utf-8',
                dataType: 'json',
                success: function(r) {
                    if (r && (r.success)) {
                        // Remove button just in case (or just because)
                        $loginBtn.remove();
                    }
                },
                processData: false,
                data: this.authResult.code
            });
        },
        disconnectServer: function() {
            // Revoke the server tokens
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