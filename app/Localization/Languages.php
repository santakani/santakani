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

use App;

/**
 * StoryController
 *
 * RESTful APIs for story resource.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Story
 */
class Languages {

    /**
     * List of all supported language code (ISO 639-1).
     *
     * @return string[]
     */
    public static function all()
    {
        return config('app.available_locale');
    }

    /**
     * If the language is suppported
     *
     * @param string $locale Language code (en, fi, zh...)
     * @return boolean
     */
    public static function has($locale)
    {
        return in_array($locale, self::all());
    }

    /**
     * Get translated name of the language.
     *
     * @param string $locale
     * @return string
     */
    public static function name($locale) {
        return locale_get_display_name($locale, App::getLocale());
    }

    /**
     * Get native name of the language. In Chinese, Chinese is written as "中文".
     *
     * @param string $locale
     * @return string
     */
    public static function nativeName($locale) {
        return locale_get_display_name($locale, $locale);
    }

    /**
     * Get English name of the language. In some situation, users are using an
     * interface of unknown language. They need  to know how to jump out.
     *
     * @param string $locale
     * @return string
     */
    public static function englishName($locale)
    {
        return locale_get_display_name($locale, 'en');
    }

    /**
     * All supported languages with language code, localized and native names.
     *
     * @return array
     */
    public static function names()
    {
        $names = [];
        foreach (self::all() as $locale ) {
            $names[$locale] = [
                'localized' => self::name($locale),
                'native' => self::nativeName($locale),
                'english' => self::englishName($locale),
            ];
        }
        return $names;
    }

    public static function withRegion($locale)
    {
        $regions = [
            'de' => 'de_DE',
            'en' => 'en_US',
            'es' => 'es_ES',
            'fi' => 'fi_FI',
            'fr' => 'fr_FR',
            'pt' => 'pt_PT',
            'sv' => 'sv_SE',
            'zh' => 'zh_CN',
        ];

        return isset($regions[$locale]) ? $regions[$locale] : $locale;
    }

    public static function dateFormat($locale = null)
    {
        if (!$locale) {
            $locale = App::getLocale();
        }

        $formats = [
            'de' => '%A %d %B %Y',
            'en' => '%A %d %B %Y',
            'es' => '%A %d %B %Y',
            'fi' => '%A %d %B %Y',
            'fr' => '%A %d %B %Y',
            'pt' => '%A %d %B %Y',
            'sv' => '%A %d %B %Y',
            'zh' => '%Y 年%B %d 日%A',
        ];

        return isset($formats[$locale]) ? $formats[$locale] : '%A %d %B %Y';
    }
}
