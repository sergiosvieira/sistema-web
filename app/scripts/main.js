jQuery(function () {
    document.getElementById('showPassword').onclick = show_hide;
});

var show_hide = () => {
    var pass = document.getElementById('password');
    if (pass != null) {
        if (pass.type == "text") {
            pass.type = "password";
        } else {
            pass.type = "text";
        }
    }
}