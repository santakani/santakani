<?php namespace App\Http\Middleware;

use Closure;

use Html2Text\Html2Text;
use HTMLPurifier;
use HTMLPurifier_Config;

class SafeText {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Remove HTML markups in text https://github.com/mtibben/html2text
        foreach (['name', 'title', 'tagline'] as $key) {
            if ($request->has($key)) {
                $raw_text = new Html2Text($request->input($key));
                $text = $raw_text->getText();
                $request->merge([$key => $text]);
            }
        }

        // Secure HTML input http://htmlpurifier.org/
        $config = HTMLPurifier_Config::createDefault();
        $cache_path = storage_path('app/cache/html_purifier');
        if (!file_exists($cache_path)) {
            mkdir($cache_path, 0755, true);
        }
        $config->set('Cache.SerializerPath', $cache_path);
        $html_purifier = new HTMLPurifier($config);
        foreach (['content'] as $key) {
            if ($request->has($key)) {
                $text = $html_purifier->purify($request->input($key));
                $request->merge([$key => $text]);
            }
        }

        return $next($request);
    }

}
