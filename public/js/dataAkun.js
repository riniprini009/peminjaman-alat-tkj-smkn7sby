let filterState = {
    role: "",
};

let timerEditUsername;


$(document).ready(function () {
    // ===================== FILTER =====================
    $("#btnApplyFilter").on("click", function () {
        table.column(3).search(filterState.role).draw();

        let total = 0;
        if (filterState.role) total++;

        $("#filterBadge")
            .text(total)
            .toggle(total > 0);

        $("#filterModal").modal("hide");
    });

    $("#btnResetFilter").on("click", function () {
        filterState.role = "";

        $("select.filter-input").prop("selectedIndex", 0);

        table.search("").columns().search("").draw();

        $("#filterBadge").hide().text("0");
    });

    $("#filterRole").on("change", function () {
        filterState.role = $(this).val();
    });

    // ===================== EXPORT =====================
    window.exportPdf = function () {
        let url = "/export-akun-user";

        if (filterState.role) {
            url += "?role=" + encodeURIComponent(filterState.role);
        }

        window.open(url, "_blank");
    };

    // ===================== BUTTON SUBMIT MODAL =====================
    const $btnEdit = $("#form-edit-akun button[type='submit']");

    let usernameValid = true;
    let passwordValid = true;

    // ===================== OPEN MODAL =====================
    $(document).on("click", ".btn-edit", function () {
        let id = $(this).data("id-akun");
        let nama = $(this).data("nama-user");
        let username = $(this).data("username");
        let role = $(this).data("role");

        $("#id-akun-user").val(id);

        $("#nama-user").val(nama);

        $("#username").val(username).attr("data-original", username);

        $("#role").val(role);

        $("#password-baru").val("");
        $("#conf-pwd").val("");

        $("#edit-username-error").addClass("d-none").text("");

        $("#edit-pwd-error").addClass("d-none").text("");

        usernameValid = true;
        passwordValid = true;

        $btnEdit.prop("disabled", false);

        $("#form-edit-akun").attr("action", "/update-akun/" + id);

        $("#modal-edit-akun").modal("show");
    });

    // ===================== CHECK USERNAME =====================
    $("#username").on("input", function () {
        clearTimeout(timerEditUsername);

        let username = $(this).val().trim();
        let idAkun = $("#id-akun-user").val();

        usernameValid = false;

        $("#edit-username-error").addClass("d-none").text("");

        // kosong
        if (username === "") {
            $btnEdit.prop("disabled", true);
            return;
        }

        // username lama
        let originalUsername = $("#username").attr("data-original");

        if (username.toLowerCase() === originalUsername.toLowerCase()) {
            usernameValid = true;
            checkEditForm();
            return;
        }

        $btnEdit.prop("disabled", true);

        timerEditUsername = setTimeout(function () {
            $.ajax({
                url: "/akun/check-username",
                method: "POST",
                data: {
                    username: username,
                    id_akun_user: idAkun,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },

                success: function (res) {
                    if ($("#username").val().trim() !== username) return;

                    if (res.exist) {
                        usernameValid = false;

                        $("#edit-username-error")
                            .removeClass("d-none")
                            .text("Username sudah digunakan");

                        $btnEdit.prop("disabled", true);
                    } else {
                        usernameValid = true;

                        $("#edit-username-error").addClass("d-none").text("");

                        checkEditForm();
                    }
                },
            });
        }, 300);
    });

    // ===================== CHECK PASSWORD =====================
    // ===================== CHECK PASSWORD =====================
    $("#password-baru, #conf-pwd").on("input", function () {
        let pwd = $("#password-baru").val().trim();
        let conf = $("#conf-pwd").val().trim();

        $("#edit-pwd-error").addClass("d-none").text("");

        // kosong semua
        if (pwd === "" && conf === "") {
            passwordValid = true;

            checkEditForm();
            return;
        }

        // salah satu masih kosong
        if (pwd === "" || conf === "") {
            passwordValid = false;

            $btnEdit.prop("disabled", true);
            return;
        }

        // tidak sama
        if (pwd !== conf) {
            passwordValid = false;

            $("#edit-pwd-error")
                .removeClass("d-none")
                .text("Konfirmasi password tidak sama");

            $btnEdit.prop("disabled", true);
        } else {
            passwordValid = true;

            $("#edit-pwd-error").addClass("d-none").text("");

            checkEditForm();
        }
    });

    // ===================== CHECK FORM =====================
    function checkEditForm() {
        let username = $("#username").val().trim();
        let role = $("#role").val();

        let valid =
            username !== "" && role !== "" && usernameValid && passwordValid;

        $btnEdit.prop("disabled", !valid);
    }
});
