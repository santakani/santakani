<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Localization;

use Carbon\Carbon;

/**
 * Manage and process currency data and exchange rates.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Currency
 */
class Currencies {

    protected static $currency_list = ['EUR', 'SEK', 'NOK', 'DKK', 'GBP', 'CHF', 'USD', 'CNY'];

    protected static $exchange_rates = null;

    protected static $exchange_rates_publish_date = null;

    const exchange_file_path = 'app/data/exchange.json';

    const exchange_api_url = 'http://api.fixer.io/latest';

    protected static function initialize()
    {
        // Exchange update
        if (empty(self::$exchange_rates)) {
            if (self::checkExchangeRate()) {
                // Up-to-date
                self::readExchangeRate();
            } else {
                // Out-dated
                self::updateExchangeRate();
            }
        }
    }

    protected static function checkExchangeRate()
    {
        $path = storage_path(self::exchange_file_path);

        if (!file_exists($path)) {
            return false;
        }

        $time = Carbon::createFromTimestamp(filemtime($path));

        // Update rate is 6 hours, the API update rate is 1 day
        if ($time->addHours(6)->lt(Carbon::now())) {
            return false;
        }

        return true;
    }

    protected static function readExchangeRate()
    {
        $path = storage_path(self::exchange_file_path);
        $json = file_get_contents($path);
        $arr = json_decode($json, true);
        self::$exchange_rates = $arr['rates'];
        self::$exchange_rates_publish_date = new Carbon($arr['date']);
    }

    protected static function updateExchangeRate()
    {
        $path = storage_path(self::exchange_file_path);

        $json = file_get_contents(self::exchange_api_url);

        file_put_contents($path, $json);

        $array = json_decode($json, true);
        self::$exchange_rates = $array['rates'];
        self::$exchange_rates_publish_date = new Carbon($array['date']);
    }

    public static function all()
    {
        return self::$currency_list;
    }

    /**
     * @param string $currency
     * @return float
     */
    public static function rate($currency)
    {
        self::initialize();

        $currency = strtoupper($currency);

        if ($currency === 'EUR') {
            return 1;
        }

        if (array_key_exists($currency, self::$exchange_rates)) {
            return self::$exchange_rates[$currency];
        } else {
            return null;
        }
    }
}
