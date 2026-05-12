
let filterState = {
    kelas: "",
};

function countActiveFilters() {
    let count = 0;

    if (filterState.kelas) count++;
    return count;
}

$(document).ready(function () {
    // ===================== FILTER =====================

    $(".btn-universal").on("click", function () {
        table.column(3).search(filterState.kelas).draw();
        let total = countActiveFilters();

        $("#filterBadge")
            .text(total)
            .toggle(total > 0);
        $("#filterModal").modal("hide");
    });

    $(".btn-back").on("click", function () {
        filterState = {
            kelas: "",
        };

        $("select.filter-input").prop("selectedIndex", 0);
        table.search("").columns().search("").draw();

        $("#filterBadge").hide().text("0");
    });

    // ===================== SEARCH =====================

   

    // ===================== DROPDOWN FILTER =====================
    $("#filterKelas").on("change", function () {
        filterState.kelas = $(this).val();
    });

    // ========================= EXPORT =========================
    window.exportPdf = function () {
        let url = "/export-siswa";

        if (filterState.kelas) {
            url += "?kelas=" + encodeURIComponent(filterState.kelas);
        }

        window.open(url, "_blank");
    };

    // ========================= EDIT =========================
    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();

        let idSiswa = $(this).data("id-siswa");
        let namaSiswa = $(this).data("nama-siswa");
        let nis = $(this).data("nis");
        let kelas = $(this).data("kelas");
        let jenis = $(this).data("jenis-kelamin");

        $("#id-siswa").val(idSiswa);
        $("#nama-siswa").val(namaSiswa);
        $("#nis").val(nis);
        $("#kelas").val(kelas);
        $("#jenis-kelamin").val(jenis);

        $("#edit-data-siswa").attr("action", "/update-siswa/" + idSiswa);

        $("#modal-edit-data-siswa").modal("show");
    });

    // ========================= DELETE =========================
   
});
