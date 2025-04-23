$(document).ready(() => {

    //Send Email
    $('#submit').on('click', function (e) {
        e.preventDefault();

        const email = $('#email').val();

        const check = email.substring(email.lastIndexOf('@') + 1);

        if (!email) {

            // toastr["error"]("Email is required.", "ERROR");
            alert("Email is required.");
            $('#email').focus();
            return

        } else if (check !== 'innogroup.com.ph' && check !== 'induco.com.ph' && check !== 'citrineland.com.ph' && check !== 'innoland.com.ph' && check !== 'innoprime.com.ph') {

            // toastr["error"]("Enter a valid IGC email address. (ex. your_email@innogroup.com.ph).", "ERROR");
            alert("Enter a valid IGC email address.");
            $("#email").focus();

        } else {

            $.ajax({
                type: 'POST',
                url: 'controls/forgot_password.ctrl.php',
                data: { email: email },
                success: function (r) {
                    console.log(r);
                    if (r > 0) {
                        // alert("sent");
                        // window.location.reload();

                        // Swal.fire({
                        //     title: "Success!",
                        //     text: "A message has been sent to your IGC email address with instructions to reset your password. Please check your Outlook app.",
                        //     icon: "success",
                        //     allowOutsideClick: false,
                        //     allowEscapeKey: false,
                        //     confirmButtonColor: "#007bff",
                        // }).then(function () {
                        //     window.location.reload();
                        // });
                        alert("A message has been sent to your IGC email address with instructions to reset your password. Please check your Outlook app.");
                        window.location.reload();

                    } else {
                        // toastr["error"]("Email not found.", "ERROR");
                        alert("Email not found.");
                    }
                }


            });
        }
    });

});