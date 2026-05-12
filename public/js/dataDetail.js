// ===================== STATE =====================
let filterState = {
    kondisi_alat: "",
};

// ===================== HELPER =====================
function countActiveFilters() {
    let count = 0;

    if (filterState.kondisi_alat) count++;
    return count;
}
$(document).ready(function () {
    // ===================== DROPDOWN FILTER =====================
    $("#filterKondisi").on("change", function () {
        filterState.kondisi_alat = $(this).val();
    });

    // ===================== FILTER APPLY =====================
    $("#btn-apply-filter").on("click", function () {
        table
            .column(2)
            .search(
                filterState.kondisi_alat
                    ? "^" + filterState.kondisi_alat + "$"
                    : "",
                true,
                false,
            )
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
            kondisi_alat: "",
        };

        $("select.filter-input").prop("selectedIndex", 0);
        table.search("").columns().search("").draw();
        $("#filterBadge").hide().text("0");
    });

    window.exportPdf = function (idTipe) {
        let url = "/export-detail/" + idTipe;
        let params = [];

        if (filterState.kondisi_alat) {
            params.push(
                "kondisi_alat=" + encodeURIComponent(filterState.kondisi_alat),
            );
        }

        if (filterState.status_alat) {
            params.push(
                "status_alat=" + encodeURIComponent(filterState.status_alat),
            );
        }

        if (params.length > 0) {
            url += "?" + params.join("&");
        }

        window.open(url, "_blank");
    };

    $(document).on("click", ".btn-add", function (e) {
        e.preventDefault();
        $("#modal-add-data-detail").modal("show");
    });

    $("#modal-add-data-detail").on("hidden.bs.modal", function () {
        $(this).find("form")[0].reset();
    });

    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();
        let idDetail = $(this).data("id-detail");
        let kondisiAlat = $(this).data("kondisi-alat");

        $("#kondisi-alat").val(kondisiAlat);
        $("#edit-detail-form").attr("action", "/update-detail/" + idDetail);
        $("#modal-edit-data-detail").modal("show");
    });
});
