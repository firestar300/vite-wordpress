# Vite ⚡️ WordPress

Vite WordPress is a simple and quick WordPress starter theme using the fastest build tool: [Vite](https://vitejs.dev/).

## Get started 🚀

### Set WP_ENV constant

In your `wp-config.php` file, you have to define a `WP_ENV` constant according to your environment so that Vite WordPress can determine which assets need to be loaded.
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

### Development 🛠

Run your local backend server, then in your theme run :
```bash
$ yarn dev
```

### Build 📦

```bash
$ yarn build
```

## Known issues 🪲

### HTTPS

The theme currently doesn't work in dev environment with a https server. There is an infinite HMR reloading loop.

## [Change logs](CHANGELOG.md)
