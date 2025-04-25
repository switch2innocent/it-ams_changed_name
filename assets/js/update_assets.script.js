$(document).ready(function () {
    // Restrict input fields with the class .restrict
    $('.restrict').on('input', function () {
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