# URL Shortening!

[Live DEMO](https://ur.onlihop.com)
![enter image description here](https://fv9-3.failiem.lv/thumb_show.php?i=hyy8u6pa7&view)
URL Shortener is a simple easy to use built using Laravel. It allows you to shorten long URLs into easy-to-remember short links.

# Features

-   Authentication using [Laravel Breeze](https://laravel.com/docs/9.x/starter-kits#laravel-breeze)
-   Registration
-   Login
-   Profile
-   Shorten URL
-   Feature test
-   Scheduled Job to delete links older than 30 days
-   Track detail information of visitors using [Agent](https://github.com/jenssegers/agent)
-   API for Shortening URL
-   Shorten URL form using [filament/forms](https://filamentphp.com/docs/2.x/forms)
-   Advanced Data table with dynamic filtering using [filament/table](https://filamentphp.com/docs/2.x/tables/installation)
-   Enable Tracking
-   Enforce Https
-   Tracking IP
-   Tracking Browser and version
-   Tracking Device Type
-   Tracking Device Name
-   Tracking Operating System
-   Track Referrer URL

## How to run?

1.  `composer install`
2.  `npm install`
3.  `npm run build`
4.  `cp .env.example .env`
5.  `php artisan key:generate`
6.  `Configure your .env setting for your database "DB_DATABASE"`
7.  `php artisan migrate`
8.  `php artisan serve`
