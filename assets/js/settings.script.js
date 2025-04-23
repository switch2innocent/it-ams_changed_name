$(document).ready(() => {

    //Search barcode on enter key press
    $('#search_val').on('keypress', (e) => {
        if (e.which === 13) { // 13 Enter key
            e.preventDefault();

            const search_val = $('#search_val').val();

            if (search_val && search_val.trim() !== "") {
                window.location.href = 'search_barcode.php?search_val=' + encodeURIComponent(search_val);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please enter a barcode to search!'
                });
            }
        }
    });

    //Search barcode on button click
    $('#search_btn').on('click', () => {
        const search_val = $('#search_val').val();

        if (search_val && search_val.trim() !== "") {
            window.location.href = 'search_barcode.php?search_val=' + encodeURIComponent(search_val);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please enter a barcode to search!'
            });
        }
    });

    //Update Profile
    $('#update_profile').on('click', (e) => {
        e.preventDefault();

        const user_id = $('#user_id').val();
        const fname = $('#firstname').val();
        const lname = $('#lastname').val();
        const pass = $('#password').val();
        const conpassword = $('#confirm_password').val();

        if (fname == "" || lname == "") {

            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please fill in all fields!'
            });

        } else if (pass !== conpassword) {

            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Password does not match. Please try again.'
            });

        } else {

            $.ajax({
                type: 'POST',
                url: 'controls/update_profiles.ctrl.php',
                data: {
                    user_id: user_id,
                    fname: fname,
                    lname: lname,
                    pass: pass
                },
                success: function (r) {

                    if (r > 0) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Updated',
                            text: 'Your profile has been updated successfully. You will be logged out to save changes.'
                        }).then(() => {
                            window.location.href = 'controls/logout_users.ctrl.php';
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: 'Failed to update profile. Please try again later.'
                        });

                    }
                },
                error: function () {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the profile. Please try again later.'
                    });

                }
            });
        }
    });


});