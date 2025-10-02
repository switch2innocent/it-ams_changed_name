//Add image preview
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}

//Update image preview
function upd_previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('upd_preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}

$(document).ready(() => {

    //Init select2 add modal
    $('#accountable_name, #user, #department, #location').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent()
        });
    });

    //Set #user selection if accountable is selected
    $('#accountable_name').on('change', function () {

        const selectedAccountable = $(this).val();

        // console.log(selectedAccountable);
        if (selectedAccountable) {
            $('#user').val(selectedAccountable).trigger('change');
        }
    });

    //Server side datatable for desktop pc
    $('#desktop_pc').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/desktop_pc_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for avr ups
    $('#avr_ups').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/avr_ups_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for laptop
    $('#laptop').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/laptop_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for printer
    $('#printer').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/printer_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for server
    $('#server').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/server_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for computer peripheral
    $('#computer_peripheral').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/computer_peripheral_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for network device
    $('#network_device').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/network_device_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for scanner
    $('#scanner').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/scanner_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for communicator
    $('#communication').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/communication_dtable.php',
            type: 'POST',
        }
    });

    //Server side datatable for defective
    $('#defective').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/defective_dtable.php',
            type: 'POST',
        }
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
        const img_file = $("#upload_img")[0].files[0];

        const formData = new FormData();
        formData.append('form_type', form_type);
        formData.append('barcode_no', barcode_no);
        formData.append('item_desc', item_desc);
        formData.append('account_name', account_name);
        formData.append('user', user);
        formData.append('dept', dept);
        formData.append('loc', loc);
        formData.append('bldg_level', bldg_level);
        formData.append('status', status);
        formData.append('remarks', remarks);
        formData.append('img_file', img_file);

        if (!form_type || !barcode_no || !item_desc || !account_name || !user || !dept || !loc || !bldg_level || !status || !remarks) {
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
                data: formData,
                processData: false,
                contentType: false,
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

    //Edit assets
    $('#desktop_pc, #avr_ups, #laptop, #printer, #server, #computer_peripheral, #network_device, #scanner, #communication, #defective tbody').on('click', 'a.edit', function () {

        const id = $(this).data('id');
        const myModal = new bootstrap.Modal(document.getElementById('editModal'), {
            backdrop: 'static',
            keyboard: false
        });


        $.ajax({
            type: 'POST',
            url: 'controls/get_assets.ctrl.php',
            data: { id: id },
            success: function (r) {
                myModal.show();
                $('#edit_modalBody').html(r);
                // Restrict input fields with the class .restrict
                $('.restrict').on('input', function () {
                    $(this).val($(this).val().replace(/[^a-zA-Z0-9\s-]/g, ''));
                });


                //Init select2 for update
                $('#upd_acct_name, #upd_user, #upd_dept, #upd_location').each(function () {
                    $(this).select2({
                        dropdownParent: $(this).parent()
                    });
                });

                //Set #user selection if accountable is selected
                $('#upd_acct_name').on('change', function () {

                    const selectedAccountable = $(this).val();

                    // console.log(selectedAccountable);
                    if (selectedAccountable) {
                        $('#upd_user').val(selectedAccountable).trigger('change');
                    }
                });
                
                $('.reason').fadeIn(2000);
            }
        });

    });

    //View assets
    $('#desktop_pc, #avr_ups, #laptop, #printer, #server, #computer_peripheral, #network_device, #scanner, #communication, #defective tbody').on('click', 'a.view', function () {

        const id = $(this).data('id');
        const myModal = new bootstrap.Modal(document.getElementById('viewModal'), {
            backdrop: 'static',
            keyboard: false
        });


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
                    text: 'Please enter a barcode or accountable person to search!'
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
                text: 'Please enter a barcode or accountable person to search!'
            });
        }
    });

    //Restrict textboxes
    $('.restrict').on('input', function () {
        // Only allow letters, numbers, spaces, and minus sign (-)
        $(this).val($(this).val().replace(/[^a-zA-Z0-9\s-]/g, ''));
    });

    //Shows hidden reasons on change
    // $(document).on('click', '#upd_stat', function () {
    //     const selectedValue = parseInt($(this).val(), 10); //Convert to number
    //     console.log(selectedValue);

    //     $('.reason').fadeIn(1000);
    // });

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
    const upd_acct_name_text = $('#upd_acct_name option:selected').text();
    const upd_user_text = $('#upd_user option:selected').text();
    const upd_dept_text = $('#upd_dept option:selected').text();
    const upd_location_text = $('#upd_location option:selected').text();
    const upd_stat_text = $('#upd_stat option:selected').text();
    const upd_id = $('#upd_id').val();
    const upd_reason = $('#upd_reason').val();
    const upd_img_file = $("#upd_upload_img")[0].files[0];

    const src = $('#upd_preview').attr('src');
    const fileName = src.substring(src.lastIndexOf('/') + 1);

    const verify_formData = new FormData();
    verify_formData.append('upd_item_desc', upd_item_desc);
    verify_formData.append('upd_acct_name', upd_acct_name);
    verify_formData.append('upd_user', upd_user);
    verify_formData.append('upd_dept', upd_dept);
    verify_formData.append('upd_location', upd_location);
    verify_formData.append('upd_bldg_lvl', upd_bldg_lvl);
    verify_formData.append('upd_stat', upd_stat);
    verify_formData.append('upd_remarks', upd_remarks);
    verify_formData.append('upd_id', upd_id);
    verify_formData.append('fileName', fileName);

    const formData = new FormData();
    formData.append('upd_bar_no', upd_bar_no);
    formData.append('upd_item_desc', upd_item_desc);
    formData.append('upd_acct_name', upd_acct_name);
    formData.append('upd_user', upd_user);
    formData.append('upd_dept', upd_dept);
    formData.append('upd_location', upd_location);
    formData.append('upd_bldg_lvl', upd_bldg_lvl);
    formData.append('upd_stat', upd_stat);
    formData.append('upd_remarks', upd_remarks);
    formData.append('upd_created_by', upd_created_by);
    formData.append('upd_dept_text', upd_dept_text);
    formData.append('upd_location_text', upd_location_text);
    formData.append('upd_stat_text', upd_stat_text);
    formData.append('upd_id', upd_id);
    formData.append('upd_reason', upd_reason);
    formData.append('upd_img_file', upd_img_file);

    if (!upd_bar_no || !upd_item_desc || !upd_acct_name || !upd_user || !upd_dept || !upd_location || !upd_bldg_lvl || !upd_stat || !upd_remarks) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Fields',
            text: 'Please fill in all fields.',
        });
        return;
    } else if (!upd_reason) {
        Swal.fire({
            icon: 'warning',
            title: 'Reason for Update',
            text: 'Please enter a valid reason for updating this asset.',
        });
        return;
    } else {
        //Verify
        $.ajax({
            type: 'POST',
            url: 'controls/verify_update_assets.ctrl.php',
            data: verify_formData,
            processData: false,
            contentType: false,
            success: (r) => {
                console.log(r);
                if (r > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Asset with same details already exists',
                        text: 'The asset you are trying to update already exists. Please check and use unique details.',
                    });
                } else {
                    //Update
                    $.ajax({
                        type: 'POST',
                        url: 'controls/update_assets.ctrl.php',
                        data: formData,
                        processData: false,
                        contentType: false,
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