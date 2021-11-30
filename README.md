# Vite WordPress

Vite WordPress is a simple and quick WordPress starter theme using the fastest build tool: [Vite](https://vitejs.dev/).

## Get started

### Set WP_ENV constant

In your `wp-config.php` file, you have define a `WP_ENV` constant according to your environment so that Vite WordPress can determine which assets need to be loaded.
In case you are in development mode, set the constant to `development`.

```php
define( 'WP_ENV', 'development' );
```

In production, set the constant to `production`.
```php
define( 'WP_ENV', 'production' );
```

### Install dependencies

Inside the starter theme, run :
```bash
$ yarn

# OR

$ npm install
```

## [Change logs](CHANGELOG.md)

## Readme coming soon...