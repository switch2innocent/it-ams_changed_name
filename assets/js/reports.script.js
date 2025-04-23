$(document).ready(() => {

    //Init
    const select2Elements = [
        $('#barcode').select2(),
        $('#description').select2(),
        $('#acct').select2(),
        $('#department').select2(),
        $('#location').select2(),
        $('#status').select2()
    ];

    //Disable other select2 if 1 is selected
    select2Elements.forEach((element) => {
        element.on('select2:select', () => {
            select2Elements.forEach((el) => {
                if (el !== element) {
                    el.prop('disabled', true);
                }
            });
        });
    });

    //Reset select2
    $('#reset').on('click', (e) => {
        window.location.reload();
    });

    //Generate PDF
    $('#generatePDF').on('click', (e) => {
        e.preventDefault();

        const bar_no = $('#barcode').val();
        const desc = $('#description').val();
        const acct = $('#acct').val();
        const dept = $('#department').val();
        const loc = $('#location').val();
        const stat = $('#status').val();

        if (bar_no != null) {
            window.open('controls/generate_pdf.ctrl.php?bar_no=' + bar_no);
        } else if (desc != null) {
            window.open('controls/generate_pdf.ctrl.php?desc=' + desc);
        } else if (acct != null) {
            window.open('controls/generate_pdf.ctrl.php?acct=' + acct);
        } else if (dept != null) {
            window.open('controls/generate_pdf.ctrl.php?dept=' + dept);
        } else if (loc != null) {
            window.open('controls/generate_pdf.ctrl.php?loc=' + loc);
        } else if (stat != null) {
            window.open('controls/generate_pdf.ctrl.php?stat=' + stat);
        }

        window.location.reload();
    });

    //Generate Excel
    $('#generateExcel').on('click', (e) => {
        e.preventDefault();

        const bar_no = $('#barcode').val();
        const desc = $('#description').val();
        const acct = $('#acct').val();
        const dept = $('#department').val();
        const loc = $('#location').val();
        const stat = $('#status').val();

        if (bar_no != null) {
            window.open('controls/generate_excel.ctrl.php?bar_no=' + bar_no);
        } else if (desc != null) {
            window.open('controls/generate_excel.ctrl.php?desc=' + desc);
        } else if (acct != null) {
            window.open('controls/generate_excel.ctrl.php?acct=' + acct);
        } else if (dept != null) {
            window.open('controls/generate_excel.ctrl.php?dept=' + dept);
        } else if (loc != null) {
            window.open('controls/generate_excel.ctrl.php?loc=' + loc);
        } else if (stat != null) {
            window.open('controls/generate_excel.ctrl.php?stat=' + stat);
        }

        window.location.reload();
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

});