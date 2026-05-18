$(document).ready(function () {
    let timerUsername;
    let usernameValid = false;
    let passwordValid = false;

    const $btnSubmit = $("#btn-submit");

    // ===================== DEFAULT =====================
    $btnSubmit.prop("disabled", true);

    // ===================== CHECK FORM =====================
    function checkFormValid() {
        let username = $("#username").val().trim();
        let password = $("#password").val().trim();
        let confPwd = $("#conf-pwd").val().trim();
        let role = $("#role").val();

        let lengkap =
            username !== "" &&
            password !== "" &&
            confPwd !== "" &&
            role !== "" &&
            usernameValid &&
            passwordValid;

        $btnSubmit.prop("disabled", !lengkap);
    }

    // ===================== USERNAME ERROR =====================
    function setUsernameError(msg) {
        $("#username-error").removeClass("d-none").text(msg);

        $btnSubmit.prop("disabled", true);
    }

    function clearUsernameError() {
        $("#username-error").addClass("d-none").text("");
    }

    // ===================== PASSWORD ERROR =====================
    function setPwdError(msg) {
        $("#pwd-error").removeClass("d-none").text(msg);

        $btnSubmit.prop("disabled", true);
    }

    function clearPwdError() {
        $("#pwd-error").addClass("d-none").text("");
    }

    // ===================== INPUT LISTENER =====================
    $("#password, #conf-pwd").on("input", function () {
        let password = $("#password").val().trim();
        let confPwd = $("#conf-pwd").val().trim();

        passwordValid = false;

        if (confPwd === "") {
            clearPwdError();
            checkFormValid();
            return;
        }

        if (password !== confPwd) {
            setPwdError("Konfirmasi password tidak sama");
        } else {
            passwordValid = true;
            clearPwdError();
        }

        checkFormValid();
    });

    $("#role").on("change", function () {
        checkFormValid();
    });

    // ===================== LIVE CHECK USERNAME =====================
    $("#username").on("input", function () {
        clearTimeout(timerUsername);

        let username = $(this).val().trim();

        usernameValid = false;

        clearUsernameError();

        $btnSubmit.prop("disabled", true);

        if (username === "") {
            checkFormValid();
            return;
        }

        timerUsername = setTimeout(function () {
            $.ajax({
                url: "/akun/check-username",
                method: "POST",
                data: {
                    username: username,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },

                success: function (res) {
                    if ($("#username").val().trim() !== username) return;

                    if (res.exist) {
                        setUsernameError("Username sudah digunakan");
                    } else {
                        usernameValid = true;
                        clearUsernameError();
                    }

                    checkFormValid();
                },
            });
        }, 300);
    });
});
