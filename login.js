function updateLoginButtonStatus() {
    var user = document.getElementById('user').value;
    var password = document.getElementById('password').value;
    var location = document.getElementById('location').value;
    var locationButton = document.getElementById('location');
    var loginButton = document.getElementById('loginButton');

    if (user === "Master") {
        locationButton.selectedIndex = 0;
        locationButton.disabled = true;
        loginButton.disabled = password === "";
    } else if (user === "Admin" || user === "User") {
        locationButton.disabled = false;
        loginButton.disabled = password === "" || location === "";
    } else {
        locationButton.disabled = true;
        loginButton.disabled = true;
    }
}
