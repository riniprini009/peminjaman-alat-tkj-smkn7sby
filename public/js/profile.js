$(document).ready(function () {
    const $btnUsername = $("#btn-update-username");
    const $btnPassword = $("#btn-update-password");

    let usernameValid = false;
    let confUsernameValid = false;
    let passwordValid = false;

    // ====================== CHECK FORM USERNAME ======================
    function checkUsernameForm() {
        let username = $("#username_baru").val().trim();
        let conf = $("#conf_username").val().trim();

        let valid =
            username !== "" &&
            conf !== "" &&
            usernameValid &&
            confUsernameValid;

        $btnUsername.prop("disabled", !valid);
    }

    // ====================== CHECK FORM PASSWORD ======================
    function checkPasswordForm() {
        let pwd = $("#password_baru").val().trim();
        let conf = $("#conf_pwd").val().trim();

        let valid = pwd !== "" && conf !== "" && passwordValid;

        $btnPassword.prop("disabled", !valid);
    }

    // ====================== USERNAME LIVE CHECK ======================
    $("#username_baru").on("input", function () {
        let username = $(this).val().trim();

        usernameValid = false;

        $("#username-error").addClass("d-none").text("");

        checkUsernameForm();

        // kosong
        if (username === "") {
            return;
        }

        $.ajax({
            url: "/akun/check-username",
            method: "POST",
            data: {
                username: username,
                id_akun_user: "{{ $siswa->akunUser->id_akun_user }}",
                _token: $('meta[name="csrf-token"]').attr("content"),
            },

            success: function (res) {
                // cegah bug async
                if ($("#username_baru").val().trim() !== username) {
                    return;
                }

                if (res.exist) {
                    usernameValid = false;

                    $("#username-error")
                        .removeClass("d-none")
                        .text("Username sudah digunakan");
                } else {
                    usernameValid = true;

                    $("#username-error").addClass("d-none").text("");
                }

                checkUsernameForm();
            },
        });
    });

    // ====================== CONFIRM USERNAME ======================
    $("#username_baru, #conf_username").on("input", function () {
        let username = $("#username_baru").val().trim();
        let conf = $("#conf_username").val().trim();

        $("#conf-username-error").addClass("d-none").text("");

        // kosong salah satu
        if (username === "" || conf === "") {
            confUsernameValid = false;
            checkUsernameForm();
            return;
        }

        // tidak sama
        if (username !== conf) {
            confUsernameValid = false;

            $("#conf-username-error")
                .removeClass("d-none")
                .text("Konfirmasi username tidak sama");
        } else {
            confUsernameValid = true;

            $("#conf-username-error").addClass("d-none").text("");
        }

        checkUsernameForm();
    });

    // ====================== PASSWORD ======================
    $("#password_baru, #conf_pwd").on("input", function () {
        let pwd = $("#password_baru").val().trim();
        let conf = $("#conf_pwd").val().trim();

        $("#pwd-error").addClass("d-none").text("");

        // kosong salah satu
        if (pwd === "" || conf === "") {
            passwordValid = false;
            checkPasswordForm();
            return;
        }

        // tidak sama
        if (pwd !== conf) {
            passwordValid = false;

            $("#pwd-error")
                .removeClass("d-none")
                .text("Konfirmasi password tidak sama");
        } else {
            passwordValid = true;

            $("#pwd-error").addClass("d-none").text("");
        }

        checkPasswordForm();
    });

    // awal disable
    $btnUsername.prop("disabled", true);
    $btnPassword.prop("disabled", true);
});
