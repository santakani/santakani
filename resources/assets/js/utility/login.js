module.exports = function (redirectURL) {

    if (app.user !== false) {
        return;
    }

    if (!redirectURL) {
        redirectURL = location.href;
    }

    location.href = '/login?redirect=' + encodeURI(redirectURL);

    return;
}
