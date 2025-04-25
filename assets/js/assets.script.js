$(document).ready(() => {

    //Init Datatable
    const table = $('#desktop_pc').DataTable({
        'columnDefs': [
            {
                'orderable': false,
                'targets': 6 //Disable ordering on action
            }
        ]
    });

    //Add assets
    $('#submit').on('click', (e) => {
        e.preventDefault();

        const form_type = $('#form_type').val();
        const barcode_no = $('#barcode_no').val();
        const item_desc = $('#item_description').val();
        const account_name = $('#accountable_name').val();
        const user = $('#user').val();
        const dept = $('#department').val();
        const loc = $('#location').val();
        const bldg_level = $('#bldg_level').val();
        const status = $('#status').val();
        const remarks = $('#remarks').val();

        if (!form_type || !barcode_no || !item_desc || !account_name || !user || !dept || !location || !bldg_level || !status || !remarks) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Fields',
                text: 'Please fill in all fields.',
            });
            return;
        } else {

            $.ajax({
                type: 'POST',
                url: 'controls/add_assets.ctrl.php',
                data: {
                    form_type: form_type,
                    barcode_no: barcode_no,
                    item_desc: item_desc,
                    account_name: account_name,
                    user: user,
                    dept: dept,
                    loc: loc,
                    bldg_level: bldg_level,
                    status: status,
                    remarks: remarks
                },
                success: (r) => {
                    if (r > 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved',
                            text: 'Asset has been successfully saved.',
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Failed to save the asset. Please try again.',
                        });
                    }
                }
            });

            // $.ajax({
            //     type: 'POST',
            //     url: 'controls/verify_barcodes.ctrl.php',
            //     data: {
            //         barcode_no: barcode_no,
            //     },
            //     success: (r) => {
            //         if (r > 0) {
            //             alert("Barcode already exists.");
            //         } else {

            //         }
            //     }
            // });

        }

    });

    //Edit assets
    $('#desktop_pc tbody').on('click', 'a.edit', function () {

        const id = $(this).data('id');
        const myModal = new bootstrap.Modal($('#editModal')[0]);

        $.ajax({
            type: 'POST',
            url: 'controls/get_assets.ctrl.php',
            data: { id: id },
            success: function (r) {
                myModal.show();
                $('#edit_modalBody').html(r);
            }
        });

    });

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

    //Restrict textboxes
    $('.restrict').on('input', function () {
        // Only allow letters, numbers, spaces, and minus sign (-)
        $(this).val($(this).val().replace(/[^a-zA-Z0-9\s-]/g, ''));
    });

});