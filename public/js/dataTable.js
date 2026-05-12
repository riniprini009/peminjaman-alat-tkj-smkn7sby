let table;
let timeout;
$(document).ready(function () {
    if (!$.fn.DataTable.isDataTable(".data-table")) {
        table = $(".data-table").DataTable({
            responsive: false,
            autoWidth: false,
            pageLength: 10,
            lengthChange: true,
            ordering: false,
            dom: "lrtip",

            language: {
                search: "",
                zeroRecords: "Data tidak ditemukan",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                lengthMenu: "_MENU_",
                paginate: {
                    next: ">>",
                    previous: "<<",
                },
            },
        });

        // $('#search-wrapper').html($('.dataTables_filter').detach());

        $("#show-entries")
            .html($(".dataTables_length").addClass("m-0 p-0").detach())
            .prepend('<span class="my-1">Show :</span>');
    }

    $("#searchInput").on("input", function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            table.search(this.value).draw();
        }, 300);
    });
    // ========================= TOOLTIP =========================
    $(function () {
        $("[title]").tooltip({
            placement: "top",
            offset: "0,3",
        });
    });
});
