# ConsTeach

*ConsTeach.com repoja*

## Telepítés:

### Composer package-ek telepítése:

    composer install

### NPM package-ek telepítése

    npm install

### Migrálás

    php artisan migrate
<br/>

### Adatbázis feltöltése random adatokkal
    
    php artisan db:seed

<br/>

### Tesztelhető fiókok elkészítése

    php artisan init:db

`teacher@example.com` `password`
`student@example.com` `password`

<br/>
<br/>
User extra fix:
    
    vendor/laravel/jetstream/src/Http/Middleware/ShareInertiaData.php

    44. $request->user()->extra();

### Nylevi file-ok pusholása

    php artisan export:messages-flat    

<br/>

Projektben lévő fontosabb PHP package-ek:
- [Laravel](https://laravel.com/docs)
- [Jetstream](https://jetstream.laravel.com/)
