$(document).ready(function () {
    // ===================== ADD =====================
    $(document).on("click", ".btn-add", function (e) {
        e.preventDefault();
        $("#modal-add-data-jenis").modal("show");
    });

    // reset form saat modal close
    $("#modal-add-data-jenis").on("hidden.bs.modal", function () {
        $(this).find("form")[0].reset();
    });

    // ===================== EDIT =====================
    $(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();

        let idJenis = $(this).data("id-jenis");
        let namaJenis = $(this).data("nama-jenis");

        $("#id-jenis").val(idJenis);
        $("#nama-jenis").val(namaJenis);
        $("#modal-edit-data-jenis").modal("show");

        $("#edit-jenis-form").attr("action", "/update-jenis/" + idJenis);
    });

    // ===================== DELETE =====================
  

    window.exportPdf = function () {
        let url = "/export-jenis";
        window.open(url, "_blank");
    };
});
