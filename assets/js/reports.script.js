$(document).ready(() => {

    //Init select2 for clearance report
    $('#acct').select2({
        dropdownParent: $('#acct').parent()
    });

    let selectedSelect2 = null;

    //init select2 on general tab 
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        const tabId = $(e.target).attr('href');
        const select2Elements = $(tabId + ' select');

        select2Elements.each(function () {
            const element = $(this);
            if (!element.hasClass('select2-hidden-accessible')) {
                if (selectedSelect2) {
                    //disable the previously selected Select2 instance
                    selectedSelect2.select2('destroy');
                    selectedSelect2 = null;
                }
                element.select2({
                    dropdownParent: element.parent()
                });
                element.on('select2:select', function () {
                    //update the selected Select2 element
                    selectedSelect2 = $(this);
                    //disable the other Select2 instances
                    select2Elements.not($(this)).each(function () {
                        $(this).select2('destroy').prop('disabled', true);
                    });
                });
            }
        });
    });

    $('#enable').on('click', function (e) {
        e.preventDefault();

        const enable_select2 = [];
        enable_select2.push('#acct2', '#department', '#location', '#status');
        enable_select2.forEach((element) => {
            if (!$(element).hasClass('select2-hidden-accessible')) {
                $(element).select2();
            } else {
                $(element).val(0).trigger('change');
            }
            $(element).prop('disabled', false);
        });
    });

    // // Disable other select2 if 1 is selected
    // select2Elements.forEach((element) => {
    //     element.on('select2:select', () => {
    //         select2Elements.forEach((el) => {
    //             if (el !== element) {
    //                 el.prop('disabled', true);
    //             }
    //         });
    //     });
    // });

    //Generate PDF
    $('#generatePDF').on('click', (e) => {
        e.preventDefault();

        // const bar_no = $('#barcode').val();
        // const desc = $('#description').val();
        const acct = $('#acct').val();
        // const dept = $('#department').val();
        // const loc = $('#location').val();
        // const stat = $('#status').val();

        // if (bar_no != null) {
        //     window.open('controls/generate_pdf.ctrl.php?bar_no=' + bar_no);
        // } else if (desc != null) {
        //     window.open('controls/generate_pdf.ctrl.php?desc=' + desc);
        // } else
        if (acct != null) {
            window.open('controls/generate_pdf.ctrl.php?acct=' + acct);
        }
        // else if (dept != null) {
        //     window.open('controls/generate_pdf.ctrl.php?dept=' + dept);
        // } else if (loc != null) {
        //     window.open('controls/generate_pdf.ctrl.php?loc=' + loc);
        // } else if (stat != null) {
        //     window.open('controls/generate_pdf.ctrl.php?stat=' + stat);
        // }

        // window.location.reload();
    });

    //Generate Excel
    $('#generateExcel').on('click', (e) => {
        e.preventDefault();

        // const bar_no = $('#barcode').val();
        // const desc = $('#description').val();
        const acct2 = $('#acct2').val();
        const dept = $('#department').val();
        const loc = $('#location').val();
        const stat = $('#status').val();

        // if (bar_no != null) {
        //     window.open('controls/generate_excel.ctrl.php?bar_no=' + bar_no);
        // } else if (desc != null) {
        //     window.open('controls/generate_excel.ctrl.php?desc=' + desc);
        // } else 

        if (acct2 != null) {
            window.open('controls/generate_excel.ctrl.php?acct=' + acct2);
        } else if (dept != null) {
            window.open('controls/generate_excel.ctrl.php?dept=' + dept);
        } else if (loc != null) {
            window.open('controls/generate_excel.ctrl.php?loc=' + loc);
        } else if (stat != null) {
            window.open('controls/generate_excel.ctrl.php?stat=' + stat);
        }

        // window.location.reload();
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

});