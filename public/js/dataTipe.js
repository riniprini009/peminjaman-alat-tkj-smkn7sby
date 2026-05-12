let filterState = {
    jenis: "",
    id_jenis: "",
};

function countActiveFilters() {
    let count = 0;

    if (filterState.jenis) count++;
    return count;
}
$(document).ready(function () {
    // ===================== STATE =====================

    // ===================== HELPER =====================

    // ===================== FILTER APPLY =====================
    $(".btn-universal").on("click", function () {
        table
            .column(1)
            .search(filterState.jenis ? "JENIS_" + filterState.jenis : "")
            .draw();

        let total = countActiveFilters();
        $("#filterBadge")
            .text(total)
            .toggle(total > 0);
        $("#filterModal").modal("hide");
    });

    // ===================== RESET =====================
    $(".btn-back").on("click", function () {
        filterState = {
            jenis: "",
            id_jenis: "",
        };

        $("select.filter-input").prop("selectedIndex", 0);
        table.search("").columns().search("").draw();
        $("#filterBadge").hide().text("0");
    });


    // ===================== DROPDOWN FILTER =====================
    $("#filterJenis").on("change", function () {
        let selected = $(this).find(":selected");

        filterState.jenis = selected.val();
        filterState.id_jenis = selected.data("id");
    });

    // ===================== EDIT =====================
    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();

        let idTipe = $(this).data("id-tipe");
        let idJenis = $(this).data("idJenis");
        let namaTipe = $(this).data("nama-tipe");
        let gambar = $(this).data("gambar");
        let stok = $(this).data("stok");
        let lokasiRak = $(this).data("lokasi-rak");

        // set input
        $("#id-jenis").val(idJenis);
        $("#nama-tipe").val(namaTipe);
        $("#preview-gambar").attr("src", gambar);
        $("#stok").val(stok);
        $("#lokasi-rak").val(lokasiRak);

        // set form action
        $("#edit-tipe-form").attr("action", "/update-tipe/" + idTipe);

        // show modal
        $("#modal-edit-data-tipe").modal("show");
    });

    // ===================== DELETE =====================

   

    // ========================= EXPORT =========================
    window.exportPdf = function () {
        let idJenis = filterState.id_jenis;
        let url = "/export-tipe";

        if (idJenis && idJenis !== "") {
            url += "?idJenis=" + encodeURIComponent(idJenis);
        }

        window.open(url, "_blank");
    };
});
