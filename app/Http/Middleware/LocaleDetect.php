<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;

use App;
use Auth;
use Closure;
use Cookie;

use App\Localization\Languages;

/**
 * Detect the language/locale of website UI and content.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * @see https://github.com/santakani/santakani.com/wiki/Languages
 * @see https://laravel.com/docs/5.2/localization
 */
class LocaleDetect {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('lang') && Languages::has($request->input('lang'))) {
            // 1. Check URL parameter
            $locale = $request->input('lang');
            App::setLocale($locale);
            // Logged-in users: save to database
            if (Auth::check()) {
                $user = Auth::user();
                $user->locale = $locale;
                $user->save();
            }
            Cookie::queue('locale', $locale, 24*60);
        } elseif (Auth::check() && Languages::has(Auth::user()->locale)) {
            // 2. Check database for logged in users
            App::setLocale(Auth::user()->locale);
        } elseif (Languages::has($request->cookie('locale'))) {
            // 3. Check cookies
            App::setLocale($request->cookie('locale'));
        } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            // 4. Check browser languages. Note that Googlebot do not have this.
            $accept_languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            foreach ($accept_languages as $lang) {
                $lang = locale_accept_from_http($lang);
                $locale = locale_lookup(Languages::all(), $lang, true, 'en');
                if (!empty($locale)) {
                    App::setLocale($locale);
                    break;
                }
            }
        }

        setlocale(LC_TIME, Languages::withRegion(App::getLocale()).'.utf8');

        return $next($request);
    }
}
