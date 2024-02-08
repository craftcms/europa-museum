<h1 align="center">Europa Museum — Craft CMS Demo</h1>

![Europa Museum homepage](homepage.png)

## Overview

_Europa_ is a fictitious art museum website build with [Craft CMS](https://craftcms.com). This repository houses the source code for our demo, which you can try for yourself by visiting [craftcms.com/demo](https://craftcms.com/demo?kind=europa).

We’ve also included instructions below for setting up the demo in a local development environment with [Docker Compose](#docker-compose) and [DDEV](https://ddev.com/).

_Europa_ shows off many of Craft’s [core features](https://craftcms.com/features) and includes some [popular plugins](https://plugins.craftcms.com/) to spark your curiosity.

### Development Technologies

- [Craft CMS 5](https://craftcms.com/docs/5.x/)
- PHP 8.2
- PostgreSQL 13
- Native [Twig](https://craftcms.com/docs/5.x/development/twig.html) templates
- Built on the [Yii 2 framework](https://www.yiiframework.com/)

Read more about Craft’s [technical requirements](https://craftcms.com/docs/5.x/requirements.html) in the official documentation.

> [!WARNING]
> This branch uses a beta version of Craft 5. Use it to [explore the new features](https://craftcms.com/blog/craft-5-beta-released) ahead of a stable release!

### Front End Dependencies

_Europa_’s front-end was built with modern Javascript and CSS tools. Craft itself has no rules about how you structure your front-end code—so we’ve taken the opportunity to share a handful of techniques that couple Twig templates with front-end interactivity.

- [Babel](https://babeljs.io/) with ES6
- [Sass](https://sass-lang.com/)
- [Laravel Mix](https://github.com/JeffreyWay/laravel-mix#readme) with [PurgeCSS](https://github.com/spatie/laravel-mix-purgecss#readme) and [Critical CSS](https://github.com/riasvdv/laravel-mix-critical#readme)
- [Highway.js](https://highway.js.org/)
- [GSAP](https://greensock.com/gsap)
- [Lazysizes](https://github.com/aFarkas/lazysizes#readme)
- [LocomotiveScroll](https://github.com/locomotivemtl/locomotive-scroll)

## Local Development

This repository is ready to use with [Docker Compose](#docker-compose) and [DDEV](#ddev).

> [!TIP]
> If you’re using a different local environment, see Craft’s [Server Requirements](https://craftcms.com/docs/5.x/requirements.html) and [Installation Instructions](https://craftcms.com/docs/5.x/install.html).

### Docker Compose

We test demo projects in automated pipelines, so the project is ready to go if you have [Docker Compose](https://docs.docker.com/compose/) installed! The `Makefile` contains all the steps to boot up the project:

```bash
# Create containers and install dependencies:
make init
# Restore the bundled database backup:
make restore
```

You can use the CLI to create a new user, as well:

```bash
docker-compose exec web php craft users/create --admin
```

> [!TIP]
> Visit the control panel in your running project `http://localhost:8080/admin`!

### DDEV

[DDEV](https://ddev.com/) is our recommended local development environment, for Craft developers at any level of experience. Our [quick-start guide](https://craftcms.com/docs/5.x/install.html) covers this process in detail—but we’ve done the config for you, so all that’s required is…

```bash
git clone https://github.com/craftcms/europa-museum.git
cd europa-museum
ddev start
ddev craft db/restore seed.sql
```

As with the vanilla Docker setup process, you can create a user for yourself with the CLI:

```bash
ddev craft users/create --admin
# ...
ddev launch admin
```

### Front End

Run `npm install` with Node 14.15.0 or later.

If you use a different site URL, update `DEFAULT_SITE_URL` in `.env` or the production build process will fail:

```
DEFAULT_SITE_URL=https://europa.ddev.site
```

You can then run any of the development scripts found in `package.json`:

- `npm run watch` to watch and automatically recompile assets for local development
- `npm run sync` to watch files and reload with BrowserSync for local development
- `npm run dev` to compile assets for local development
- `npm run prod` to compile optimized assets for production

## License

The source code of this project is licensed under the [BSD Zero Clause License](LICENSE.MD) unless stated otherwise.

The imagery used by this project is the property of each respective license holder. You are not free to use it for your own projects.
