# Oliva

## Features

* Sass for stylesheets
* ES6 for JavaScript
* [Webpack](https://webpack.github.io/) for compiling assets, optimizing images, and concatenating and minifying files
* [Browsersync](http://www.browsersync.io/) for synchronized browser testing
* [Laravel Blade](https://laravel.com/docs/5.3/blade) as a templating engine
* [Controller](https://github.com/soberwp/controller) for passing data to Blade templates

## Requirements
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- [Node.js](https://nodejs.org)
- [Bower](https://nodejs.org)
- [Gulp](http://gulpjs.com/)
- PHP >= 5.6

## Installation
1. Clone or download the repo.
2. Create an empty database.
3. Copy `.env.example` to `.env` and update environment variables.
4. Access WP admin at http://example.com/wp/wp-admin and follow the installation instructions.
4. Make sure you have the *Requirements* installed and navigate to the theme directory, then run npm install and bower install.

## Build commands

* `gulp` — Compile and optimize the files in your assets directory.
* `gulp watch` — Compile assets when file changes are made.
* `gulp --production` — Compile assets for production (no source maps).

To use BrowserSync during `gulp watch` you need to update `devUrl` at the bottom of `assets/manifest.json` to reflect your local development hostname.

## Development
During development the site is located at https://oliva.test.krig.io

## Deployment

1. (First time) Install [Composer](https://getcomposer.org/)

```
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

2. (First time) Install [Deployer](https://deployer.org/)

```
curl -LO https://deployer.org/deployer.phar
mv deployer.phar /usr/local/bin/dep
chmod +x /usr/local/bin/dep
```

3. (First time) Run `composer install`
4. Run `dep deploy test` to deploy `develop` branch to [https://oliva.test.krig.io/](https://oliva.test.krig.io/)
