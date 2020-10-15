# Status Monitor

Status monitor is a front-end for Spatie's [Laravel-uptime-monitor](https://github.com/spatie/laravel-uptime-monitor).
You can:

* Monitor the status of your websites and receive an email when something is wrong.
* Monitor the status of your SSL certificates and receive and email when they are about to expire.
* Manage monitors and SSL checks via and Admin panel.
* Create, update, or delete websites you want to monitor.
* Make monitored websites publicly visible, or visible only to logged admins.
* Create, update, or delete custom alerts for your users.
* Manually check the status of your websites and certificates.
* Optional Google Analytics integration.

## Live example

[Status Monitor - Leiden University Libraries](https://status.library.universiteitleiden.nl/)

## Table of Contents

- [Status Monitor](#status-monitor)
  - [Live example](#live-example)
  - [Table of Contents](#table-of-contents)
  - [Getting Started](#getting-started)
    - [Basic startup](#basic-startup)
    - [Changing the Status Monitor settings](#changing-the-status-monitor-settings)
    - [Logo, Favicon, CSS, JS](#logo-favicon-css-js)
  - [Make Status Monitor check the websites automatically](#make-status-monitor-check-the-websites-automatically)
  - [Testing](#testing)
  - [Credits](#credits)
  - [Notes](#notes)
  - [Contributing](#contributing)
  - [License](#license)

![Status Monitor at Leiden University Libraries](public\img\promo.png?raw=true "Status Monitor at Leiden University Libraries")

## Getting Started

### Basic startup

`composer install` - to install dependencies. You will need [Composer](https://getcomposer.org/).

Rename `.env.example` to `.env` and edit the contents to change the basics about your app.
Pay attention to the email settings which might vary on your server.

`php artisan key:generate` - to generate a Laravel application key for encrypting data.

In the folder 'database' create a new text file called database.sqlite.

`php artisan migrate:fresh --seed` - to create the tables in the database.sqlite file (migrate:fresh) and fill them with dummy data (--seed).

**For convenience Status Monitor will create an admin account for you during seeding: admin@example.com / password - DO NOT DEPLOY TO PRODUCTION SERVERS.**

To change the username and password:

`php artisan tinker`

`$user = App\User::where('email', 'admin@example.com')->first();`

`$user->password = Hash::make('insert_your_new_password_here');`

`$user->email = 'new@email.com';`

`$user->save();`

Once all of this is done:

`php artisan serve` - to launch your app.
`php artisan monitor:check-uptime` to check the websites' status manually.
`php artisan monitor:check-certificate` to check the websites' SSL status manually.

Visit `/login` - to login as an admin.

### Changing the Status Monitor settings

Edit the contents in `config\uptime-monitor.php`
Replace `email@thatWillReceiveTheNotifications.com` with your chosen email.
Please consult [Spatie's Laravel-uptime-monitor documentation](https://spatie.be/docs/laravel-uptime-monitor/v3/introduction) for further customizing the application.

### Logo, Favicon, CSS, JS

All these files are found in the `\public` folder. Modify as needed.

## Make Status Monitor check the websites automatically

As is, the app will not check the servers automatically. Two buttons have been added in the admin page to allow manual checks of the websites and the SSL certificates.

To automatically check the statuses you must have have a cronjob run on your server:

`****` `php artisan schedule:run >> /dev/null 2>&1`
(every minute check the Laravel schedule for any unexecuted tasks and discard the output.)

## Testing

Once installed locally, make sure that the Status Monitor is running correctly by running the included tests.
Front-end tests are powered by Laravel's Dusk. If you are having difficulties with this step, consult the Dusk documentation.

`php artisan serve` (the application must be running at the same time as the tests.)

`php artisan dusk:install`

`php artisan dusk`

Dusk will run a series of front end tests to make sure that the app runs correctly. If you have not set up your email settings properly, the monitor test and the SSL test are likely to fail.

## Credits

The core of this application is based on Spatie's [Laravel-uptime-monitor](https://github.com/spatie/laravel-uptime-monitor).

[Laravel](https://laravel.com/)

[Fontawesome](https://fontawesome.com/license)

## Notes

`/monitors` - admin's homepage to create and manage monitors and run manual checks.
`/alerts` - to create and manage alerts. Note: you can have multiple alerts active at the same time. We advise maximum 2 active alerts at the same time.

## Contributing

Contributions to improve Status Monitor are welcome!

## License

Status Monitor - Open Source is developed by [Giulio Menna](https://www.linkedin.com/in/giuliomenna/) for [Leiden University Libraries](https://github.com/LeidenUniversityLibrary/).

Status Monitor is open-sourced software licensed under the [GNU GENERAL PUBLIC LICENSE v3](http://www.gnu.org/licenses/gpl-3.0.en.html).
