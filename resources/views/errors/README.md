# Error Views

Contain views named after HTTP error codes, such as `404.blade.php`.

Since hard coded in Laravel framework, this folder must be named as `errors`.
See `vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php`.

These views all extend `layout/error.blade.php` layout. To improve load speed,
view doesn't contain CSS and JavaScript outside of HTML.
