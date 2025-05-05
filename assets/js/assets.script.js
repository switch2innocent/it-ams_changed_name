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

    //View assets
    $('#desktop_pc tbody').on('click', 'a.view', function () {

        const id = $(this).data('id');
        const myModal = new bootstrap.Modal($('#viewModal')[0]);

        $.ajax({
            type: 'POST',
            url: 'controls/view_assets.ctrl.php',
            data: { id: id },
            success: function (r) {
                myModal.show();
                $('#view_modalBody').html(r);
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

//Update assets
function updateAssets() {

    const upd_bar_no = $('#upd_bar_no').val();
    const upd_item_desc = $('#upd_item_desc').val();
    const upd_acct_name = $('#upd_acct_name').val();
    const upd_user = $('#upd_user').val();
    const upd_dept = $('#upd_dept').val();
    const upd_location = $('#upd_location').val();
    const upd_bldg_lvl = $('#upd_bldg_lvl').val();
    const upd_stat = $('#upd_stat').val();
    const upd_remarks = $('#upd_remarks').val();
    const upd_created_by = $('#upd_created_by').val();

    const upd_dept_text = $('#upd_dept option:selected').text();
    const upd_location_text = $('#upd_location option:selected').text();
    const upd_stat_text = $('#upd_stat option:selected').text();

    const upd_id = $('#upd_id').val();

    if (!upd_bar_no || !upd_item_desc || !upd_acct_name || !upd_user || !upd_dept || !upd_location || !upd_bldg_lvl || !upd_stat || !upd_remarks) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Fields',
            text: 'Please fill in all fields.',
        });
        return;
    } else {
        //Verify
        $.ajax({
            type: 'POST',
            url: 'controls/verify_update_assets.ctrl.php',
            data: {
                upd_item_desc: upd_item_desc,
                upd_acct_name: upd_acct_name,
                upd_user: upd_user,
                upd_dept: upd_dept,
                upd_location: upd_location,
                upd_bldg_lvl: upd_bldg_lvl,
                upd_stat: upd_stat,
                upd_remarks: upd_remarks,
                upd_id: upd_id
            },
            success: (r) => {
                if (r > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'The asset you are trying to update already exists. Please check and use unique details.',
                    });
                } else {
                    //Update
                    $.ajax({
                        type: 'POST',
                        url: 'controls/update_assets.ctrl.php',
                        data: {
                            upd_bar_no: upd_bar_no,
                            upd_item_desc: upd_item_desc,
                            upd_acct_name: upd_acct_name,
                            upd_user: upd_user,
                            upd_dept: upd_dept,
                            upd_location: upd_location,
                            upd_bldg_lvl: upd_bldg_lvl,
                            upd_stat: upd_stat,
                            upd_remarks: upd_remarks,
                            upd_created_by: upd_created_by,
                            upd_dept_text: upd_dept_text,
                            upd_location_text: upd_location_text,
                            upd_stat_text: upd_stat_text,
                            upd_id: upd_id
                        },
                        success: (r) => {
                            if (r > 0) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated',
                                    text: 'Asset has been successfully updated.',
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: 'Failed to update the asset. Please try again.',
                                });
                            }
                        }
                    });
                }
            }
        });
    }
}