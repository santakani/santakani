/*
 * Generate QR Code image for sharing
 *
 * HTML markups:
 *
 * <img class="qrcode" src="" data-url="https://santakani.com/story/234" width="300" height="300">
 */

var qrcode=require('qrcode-js');

$('img.qrcode').each(function () {
    var url = $(this).data('url');
    var base64 = qrcode.toDataURL(url, 4);
    $(this).attr('src', base64);
});
