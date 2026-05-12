
let filterState = {
    role: "",
};

function countActiveFilters() {
    let count = 0;

    if (filterState.role) count++;
    return count;
}
$(document).ready(function () {
    $(".btn-universal").on("click", function () {
        table.column(3).search(filterState.role).draw();
        let total = countActiveFilters();

        $("#filterBadge")
            .text(total)
            .toggle(total > 0);
        $("#filterModal").modal("hide");
    });

    $(".btn-back").on("click", function () {
        filterState = {
            role: "",
        };

        $("select.filter-input").prop("selectedIndex", 0);
        table.search("").columns().search("").draw();

        $("#filterBadge").hide().text("0");
    });

    // ===================== SEARCH =====================

   

    // ===================== DROPDOWN FILTER =====================
    $("#filterRole").on("change", function () {
        filterState.role = $(this).val();
    });

    // ========================= EXPORT =========================
    window.exportPdf = function () {
        let url = "/export-akun-user";
        if (filterState.role) {
            url += "?role=" + encodeURIComponent(filterState.role);
        }
        window.open(url, "_blank");
    };

    // ========================= EDIT AKUN =========================
    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();

        let idAkun = $(this).data("id-akun");
        let namaUser = $(this).data("nama-user");
        let username = $(this).data("username");
        let role = $(this).data("role");

        $("#id-akun-user").val(idAkun);
        $("#nama-user").val(namaUser);
        $("#username").val(username);
        $("#role").val(role);

        $("#form-edit-akun").attr("action", "/update-akun/" + idAkun);

        // $('#edit-data-form').attr('action', '/update-data/' + id);
        // $('#edit-ganti-password-form').attr('action', '/update-password/' + id);

        $("#modal-edit-akun").modal("show");
    });

    // ========================= DELETE AKUN =========================
  

    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        let target = $(e.target).attr("href");

        if (target == "#home7") {
            $("#myLargeModalLabel").text("Edit Data Akun User");
        } else if (target == "#profile7") {
            $("#myLargeModalLabel").text("Ganti Password");
        }
    });
});
