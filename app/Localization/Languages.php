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
     * All supported languages with language code, localized and native names.
     *
     * @return array
     */
    public static function names()
    {
        $names = [];
        foreach (self::codes() as $code ) {
            $names[$code]['localized'] = locale_get_display_name($code, App::getLocale());
            $names[$code]['native'] = locale_get_display_name($code, $code);
        }
        return $names;
    }

    /**
     * List of language code (ISO 639-1).
     *
     * @return string[]
     */
    public static function codes()
    {
        return ['en', 'fi', 'sv', 'zh', 'pt', 'es', 'fr', 'de'];
    }

    /**
     * If the language is suppported
     *
     * @param string $code Language code (en, fi, zh...)
     * @return boolean
     */
    public static function has($code)
    {
        return in_array($code, self::codes());
    }
}
