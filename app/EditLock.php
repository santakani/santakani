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

use Carbon\Carbon;

use Auth;

/**
 * Functions to lock and unlock models which are being edited
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Edit-Lock
 */

trait EditLock {

    public function lock() {
        if (!Auth::check()) {
            return false;
        } elseif (Auth::user()->id !== $this->locked_by && !empty($this->locked_at) && Carbon::now()->lt($this->locked_at->addMinutes(5))) {
            return false;
        } else {
            $this->locked_by = Auth::user()->id;
            $this->locked_at = Carbon::now();
            $timestamps_enabled = $this->timestamps;
            $this->timestamps = false;
            $this->save();
            $this->timestamps = $timestamps_enabled;
            return true;
        }
    }

}
