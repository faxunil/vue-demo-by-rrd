<p align="center"><a href="https://laravel.com" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400">
</a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Telepítés:

git clone https://github.com/faxunil/vue-demo-by-rrd.git demo
Állítsuk be a tárhelyen az adatbázist.
A .ENV fájl hozzuk létre, amelyben állítsuk be a létrehozott MySQL adatbázis eléréséhez szükséges adatokat.

composer install
php artisan key:generate
php artisan migrate:fresh --seed
artisan storage:link (ha a tárhelyen nem működik a symlink() php-s fgv akkor kézzel kell létrehozni.

## API endpointok

### Felhasználói regisztráció: `POST api/register`

Request
Header: `Content-Type: application/json`

```json
{
  "name": "rrd",
  "email": "rrd@webmania.cc",
  "password": "Gauranga"
}
```

Response

```json
{
  "data": {
    "token": "1|lrJzdF2AWrVhi4JnycictT4XmHDBbxe496uOiJnp",
    "user": {
      "email": "rrd@webmania.cc",
      "name": "rrd",
      "is_admin": 0,
      "updated_at": "2022-02-13T15:42:42.000000Z",
      "created_at": "2022-02-13T15:42:42.000000Z",
      "id": 12
    },
    "is_admin": 0
  },
  "message": "Sikeres regisztráció"
}
```

### Felhasználói bejelentkezés: `POST api/login`

Request
Header: `Content-Type: application/json`

```json
{
  "email": "rrd@webmania.cc",
  "password": "Gauranga"
}
```

Response

```json
{
  "data": {
    "token": "2|rOG4cjVwVzQPZLzyMVVoAAKFoEPafwSMvDjhdxzk",
    "user": {
      "id": 12,
      "email": "rrd@webmania.cc",
      "name": "rrd",
      "is_admin": 0,
      "tasks": [
        {
          "id": 108,
          "user_id": 12,
          "task": "rrd teszt",
          "comment": null,
          "due_date": "2022-02-28 00:00:00",
          "completed_at": null,
          "deleted_at": null,
          "created_at": "2022-02-20T12:42:36.000000Z",
          "updated_at": "2022-02-20T12:42:36.000000Z"
        }
      ]
    },
    "is_admin": 0
  },
  "message": "Logged in successfully."
}
```

### Új feladat létrehozása: `POST api/task`

Request - Bearer tokkenel
Header: `Content-Type: application/json`
`Accept: application/json`

```json
{
  "user_id": "12",
  "task": "új feladat minta",
  "due_date": "2022-02-28"
}
```

Response

```json
{
  "data": {
    "id": 101,
    "user_id": "12",
    "task": "új feladat minta",
    "comment": null,
    "due_date": "2022-02-28 00:00:00",
    "completed_at": "null",
    "duration": "00-0-7 11:34:24",
    "deleted_at": "null",
    "created_at": "2022-02-20 12:25:36",
    "updated_at": "2022-02-20 12:25:36",
    "user": {
      "id": 12,
      "email": "rrd@webmania.cc",
      "name": "rrd",
      "is_admin": 0
    }
  }
}
```

### Feladat módosítása: `PATCH task/{TASKID}`

Request - Bearer tokkenel
Header: `Content-Type: application/json`
`Accept: application/json`

```json
{
  "user_id": 12,
  "task": "módosított task név"
}
```

Response

```json
{
  "data": {
    "id": 126,
    "user_id": 12,
    "task": "módosított task név",
    "comment": null,
    "due_date": "2022-03-28 00:00:00",
    "completed_at": "",
    "duration": "00-1-5 09:7:1",
    "deleted_at": "",
    "created_at": "2022-03-13 09:02:59",
    "updated_at": "2022-03-13 09:07:01",
    "user": {
      "id": 12,
      "email": "rrd@webmania.cc",
      "name": "rrd",
      "is_admin": 0
    }
  }
}
```

### Feladat késznek jelölése: `PATCH task/{TASKID}/status`

Request - Bearer tokkenel
Header: `Content-Type: application/json`
`Accept: application/json`

```json
{
  "completed_at": "2022-03-17"
}
```

Response

```json
{
  "data": {
    "id": 107,
    "user_id": 12,
    "task": "első task szerkesztve",
    "comment": null,
    "due_date": "2022-02-25 00:00:00",
    "completed_at": "2022-03-17 00:00:00",
    "duration": "00-0-20 00:0:0",
    "deleted_at": null,
    "created_at": "2022-02-20 13:40:21",
    "updated_at": "2022-03-17 14:30:47",
    "user": {
      "id": 12,
      "email": "rrd@webmania.cc",
      "name": "rrd",
      "is_admin": 0
    }
  }
}
```

### Feladat törlése: `DELETE task/{TASKID}` - soft delete

Request - Bearer tokkenel
Header: `Content-Type: application/json`
`Accept: application/json`

A request body üres.

Response

```json
{
  "data": {
    "task": {
      "id": 108,
      "user_id": 12,
      "task": "Második task",
      "comment": null,
      "due_date": "2022-03-02 00:00:00",
      "completed_at": null,
      "deleted_at": "2022-02-20T14:26:49.000000Z",
      "created_at": "2022-02-20T13:45:39.000000Z",
      "updated_at": "2022-02-20T14:26:49.000000Z"
    }
  },
  "message": "Inaktiválva"
}
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# vue-demo-by-rrd
