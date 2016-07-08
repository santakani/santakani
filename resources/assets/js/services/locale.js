/**
 * Write language parameter to cookies. This is used for guest users.
 *
 * @see resources/views/scripts/global.blade.php
 * @see app/Http/Middleware/LocaleDetect.php
 * @see app/Localization/Languages.php
 */

var Cookies = require('js-cookie');

Cookies.set('locale', app.locale);
