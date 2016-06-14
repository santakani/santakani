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
    public static function getLanguageList()
    {
        return [
            'en' => [
                'localized' => trans('languages.english'),
                'native' => 'English',
            ],
            'fi' => [
                'localized' => trans('languages.finnish'),
                'native' => 'suomen',
            ],
            'sv' => [
                'localized' => trans('languages.swedish'),
                'native' => 'svenska',
            ],
            'zh' => [
                'localized' => trans('languages.chinese'),
                'native' => '中文',
            ],
//             'ja' => [
//                 'localized' => trans('languages.japanese'),
//                 'native' => '日本語',
//             ],
//             'ko' => [
//                 'localized' => trans('languages.korean'),
//                 'native' => '한국어',
//             ],
            'pt' => [
                'localized' => trans('languages.portuguese'),
                'native' => 'português',
            ],
            'es' => [
                'localized' => trans('languages.spanish'),
                'native' => 'español',
            ],
            'fr' => [
                'localized' => trans('languages.french'),
                'native' => 'français',
            ],
            'de' => [
                'localized' => trans('languages.german'),
                'native' => 'Deutsch',
            ],
        ];
    }

    /**
     * List of language code (ISO 639-1).
     *
     * @return string[]
     */
    public static function getLanguageCodeList()
    {
        return array_keys(self::getLanguageList());
    }

}
