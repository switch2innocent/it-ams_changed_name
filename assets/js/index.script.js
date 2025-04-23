$(document).ready(() => {

    //Login users
    $('#sign_in').on('click', (e) => {
        e.preventDefault();

        const username_email = $('#username_email').val();
        const password = $('#password').val();

        if (username_email == '' || password == '') {

            Swal.fire({
                icon: 'warning',
                title: 'Missing Fields',
                text: 'Please fill in all fields.'
            });
            return

        } else {

            $.ajax({
                type: 'POST',
                url: 'controls/login_users.ctrl.php',
                data: { username_email: username_email, password: password },
                success: (r) => {

                    if (r > 0) {

                        $.ajax({
                            type: 'POST',
                            url: 'controls/check_users_access.ctrl.php',
                            success: (r) => {
                                if (r > 0) {

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Access Granted',
                                        text: 'You have successfully logged in.',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                    }).then(function () {
                                        window.location.href = 'dashboard.php';
                                    });

                                } else {

                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Account Not Activated',
                                        text: 'Your account is not yet activated. Please contact the administrator for support.'
                                    });

                                }
                            }
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Invalid Username or Password! Please try again.'
                        });

                    }
                }
            });
        }
    });

    //Enter key
    // $(document).on('keydown', (e) => {
    //     if (e.key === 'Enter') {
    //         $('#sign_in').trigger('click');
    //     }
    // });

    //Show pass
    $('#customCheck1').on('change', function () {
        var passField = $('#password');
        if ($(this).is(':checked')) {
            passField.attr('type', 'text');
        } else {
            passField.attr('type', 'password');
        }
    });

});