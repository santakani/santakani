<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helpers;

/**
 * FileHelper
 *
 * Helper function for process files and directories.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Helper
 */
class FileHelper {

    /**
     * Remove directory recursively.
     *
     * @param string $dir
     */
    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object !== '.' && $object !== '..') {
                    $object_path = $dir . '/' . $object;
                    if (is_dir($object_path)) {
                        self::rrmdir($object_path);
                    } else {
                        unlink($object_path);
                    }
                }
            }
            rmdir($dir);
        }
    }
}
