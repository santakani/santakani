<?php namespace App\Http\Middleware;

use Closure;

/**
 * Secure HTML input http://htmlpurifier.org/
 */
class SafeHtml {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Translation content HTML
        if ($request->has('translations')) {
            $merge = false;
            $translations = $request->input('translations');

            foreach ($translations as $locale => $translation) {
                if (!empty($translation['content'])) {
                    $translations[$locale]['content'] = html_purify($translation['content']);
                    $merge = true;
                }
            }

            if ($merge) {
                $request->merge(['translations' => $translations]);
            }
        }

        return $next($request);
    }

}
