<h1 align="center">Europa Museum Craft CMS Demo</h1>

![Europa Museum homepage](homepage.png)

## Overview

The Europa Museum is a custom [Craft CMS](https://craftcms.com) marketing website for a fictitious art museum. This repository houses the source code for our demo, which you can spin up for yourself by visiting [craftcms.com/demo](https://craftcms.com/demo?kind=europa).

We’ve also included instructions below for setting up the demo in a local development environment with [Craft Nitro](https://getnitro.sh).

Europa shows off many of Craft’s core features and includes a guided tour courtesy of the [Guide](https://plugins.craftcms.com/guide) plugin.

### Development Technologies

-   [Craft CMS 3](https://craftcms.com/docs/3.x/)
-   PostgreSQL (13)
-   PHP (7.2.5+), built on the [Yii 2 framework](https://www.yiiframework.com/)
-   Native Twig templates

### Front End Dependencies

-   [Babel](https://babeljs.io/) with ES6
-   [Sass](https://sass-lang.com/)
-   [Laravel Mix](https://github.com/JeffreyWay/laravel-mix#readme) with [PurgeCSS](https://github.com/spatie/laravel-mix-purgecss#readme) and [Critical CSS](https://github.com/riasvdv/laravel-mix-critical#readme)
-   [Highway.js](https://highway.js.org/)
-   [GSAP](https://greensock.com/gsap)
-   [Lazysizes](https://github.com/aFarkas/lazysizes#readme)
-   [LocomotiveScroll](https://github.com/locomotivemtl/locomotive-scroll)

## Local Development Setup

### Environment

If you’d like to get Europa running in a local environment, we recommend using [Craft Nitro](https://getnitro.sh):

1. Follow Nitro’s [installation instructions](https://craftcms.com/docs/nitro/2.x/installation.html) for your OS.
2. Make sure you’ve used `nitro db new` to create a PostgreSQL 13 database engine.
3. Run `nitro create` with the URL to this repository:
    ```zsh
    nitro create craftcms/europa-museum europa
    ```
    - hostname: `europa.nitro`
    - web root: `web`
    - PHP version: `8.0`
    - database? `Y`
    - database engine: `postgres-13-*.database.nitro`
    - database name: `europa`
    - update env file? `Y`
4. Move to the project directory and add a Craft account for yourself by following the prompts:
    ```zsh
    cd europa
    nitro craft users/create --admin
    ```

> 💡 If you’re using a different local environment, see Craft’s [Server Requirements](https://craftcms.com/docs/3.x/requirements.html) and [Installation Instructions](https://craftcms.com/docs/3.x/installation.html).

### Front End

Run `npm install` with node 14.15.0 or later.

If you use a different site URL, update `DEFAULT_SITE_URL` in `.env` or the production build process will fail:

```
DEFAULT_SITE_URL=https://europa.nitro
```

You can then run any of the development scripts found in `package.json`:

-   `npm run watch` to watch and automatically recompile assets for local development
-   `npm run sync` to watch files and reload with BrowserSync for local development
-   `npm run dev` to compile assets for local development
-   `npm run prod` to compile optimized assets for production

## License

The source code of this project is licensed under the [BSD Zero Clause License](LICENSE.MD) unless stated otherwise.

The imagery used by this project is the property of each respective license holder. You are not free to use it for your own projects.
