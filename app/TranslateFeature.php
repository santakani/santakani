<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * TranslateFeature
 *
 * Parent class for all models with translations. Contain methods to fetch and
 * update translations.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Translation
 */

trait TranslateFeature {

    /**
     * Get translations.
     *
     * Translation class must be named as:
     * Designer => DesignerTranslation
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function translations()
    {
        return $this->hasMany(get_class($this) . 'Translation');
    }

    /**
     * Get translated text from translations. Support fallback if language not
     * available.
     *
     * @param string $field  Field name, like "name", "tagline", "content".
     * @param string $locale Language code, optional. If not set, use English(en).
     * @return string
     */
    public function text($field, $locale = 'en') {
        $translation = $this->translations()->where('locale', $locale)->first();
        if (empty($translation)) {
            if ($locale === 'en') {
                return null;
            } else {
                return $this->text($field, 'en');
            }
        } else {
            return $translation->$field;
        }
    }

}
