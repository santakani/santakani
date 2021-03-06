/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

var Backbone = require('backbone');

/**
 * Address model
 *
 * @see app/Address.php
 * @see app/Http/Controllers/AddressController.php
 */
module.exports = Backbone.Model.extend({
    defaults: {
        //
    },

    urlRoot: '/address',
});
