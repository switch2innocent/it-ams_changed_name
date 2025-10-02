$(document).ready(() => {

    //Init Datatable
    //Server side datatable for scrap
    $('#scrap').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        order: [],
        ajax: {
            url: 'controls/datatables/scrap_dtable.php',
            type: 'POST',
        }
    });

    //View Scrap
    $('#scrap tbody').on('click', 'a.view', function () {

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

});