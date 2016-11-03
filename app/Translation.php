<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Model optimized for translations.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Content-Translation
 */
class Translation extends Model
{
    /**
     * If translation has a message and it is not empty. If it is HTML, remove all
     * tags.
     *
     * @param string $field
     * @return boolean
     */
    public function hasText($field)
    {
        return !app_empty_text($this->$field);
    }

    public function hasHtml($field)
    {
        return !app_empty_html($this->$field);
    }

    public function text($field)
    {
        return $this->$field;
    }

    public function html($field)
    {
        return $this->$field;
    }

    public function excerpt($field, $length = 200)
    {
        $text = strip_tags($this->$field);
        if (grapheme_strlen($text) > $length) {
            return grapheme_substr($text, 0, $length) . '...';
        } else {
            return $text;
        }
    }
}
