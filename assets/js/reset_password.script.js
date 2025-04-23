$(document).ready(() => {

    //Submit reset password
    $('#submit').on('click', function (e) {
        e.preventDefault();

        var password = $('#password').val();
        var conpassword = $('#confirm_password').val();
        var id = location.search.split('id=')[1];

        if (!password || !conpassword) {

            // toastr["error"]("Please fill in all fields.", "ERROR");
            alert("Please fill in all fields.");

        } else if (password !== conpassword) {

            // toastr["error"]("Password do not match. Please try again.", "ERROR");
            alert("Password do not match. Please try again.");

        } else {
            $.ajax({
                type: 'POST',
                url: 'controls/change_password.ctrl.php',
                data: { password: password, id: id },
                success: function (r) {
                    if (r > 0) {

                        // Swal.fire({
                        //     title: "Success!",
                        //     text: "",
                        //     text: "Your password has been successfully reset. Please login with your new password.",
                        //     icon: "success",
                        //     allowOutsideClick: false,
                        //     allowEscapeKey: false,
                        //     confirmButtonColor: "#007bff",
                        // }).then(function () {
                        //     window.location.href = 'index.php';
                        // });

                        alert("Your password has been successfully reset. Please login with your new password.");
                        window.location.href = 'index.php';

                    } else {
                        // toastr["error"]("Failed to reset password.", "ERROR");
                        alert("Failed to reset password.");
                    }
                }

            });
        }

    });

});