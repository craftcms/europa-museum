## About nystudio107/Europa Museum

This is conversion of the Craft CMS demo site [Europa Museum](https://craftcms.com/demo) to a Docker-ized setup that uses [Vite.js](https://vitejs.dev/) modern frontend tooling.

[![Click to Play Video](https://img.youtube.com/vi/_ShZxcXLeXc/0.jpg)](https://www.youtube.com/watch?v=_ShZxcXLeXc)

(Click to Play Video)

Related articles & podcasts:

* [Vite.js Next Generation Frontend Tooling + Craft CMS](https://nystudio107.com/blog/using-vite-js-next-generation-frontend-tooling-with-craft-cms) article
* [An Annotated Docker Config for Frontend Web Development](https://nystudio107.com/blog/an-annotated-docker-config-for-frontend-web-development) article
* [Using Make & Makefiles to Automate your Frontend Workflow](https://nystudio107.com/blog/using-make-makefiles-to-automate-your-frontend-workflow) article
* [Vite.js modern frontend tooling](https://devmode.fm/episodes/vite-js-modern-frontend-tooling) podcast
* [Introduction to Vite in Craft CMS](https://craftquest.io/livestreams/introduction-to-vite-in-craft-cms) video

## Try It Yourself!

### Initial setup

All you'll need is [Docker desktop](https://www.docker.com/products/docker-desktop) for your platform installed, then spin up the Europa Museum site in local development.

Ensure no other local development environments are running that might have port conflicts, then:

1. Clone the git repo with:
```
git clone https://github.com/nystudio107/europa-museum.git
```
  
2. Go into the project's directory:
```
   cd europa-museum
```

3. Start up the site by typing this in the project's root directory:
```
make dev
```
(the first build will be somewhat lengthy, ignore the warnings from `queue_1`).

If it appears to hang at `Building php_xdebug`, your PhpStorm or other IDE is likely waiting for an Xdebug connection; quit PhpStorm or stop it from listening for Xdebug during the initial build.

4. Once the site is up and running (see below), navigate to:
```
http://localhost:8000
```

The Vite dev server for Hot Module Replacement (HMR) serving of static resources runs off of `http://localhost:3000`

🎉 You're now up and running Nginx, PHP, MySQL 8, Redis, Xdebug, & Vite without having to do any devops!

The first time you do `make dev` it will be slow, because it has to build all of the Docker images.

Subsequent `make dev` commands will be much faster, but still a little slow because we intentionally do a `composer install` and an `npm install` each time, to keep our dependencies in sync.

Wait until you see the following to indicate that the PHP container is ready:

```
php_1         | Craft is installed.
php_1         | Applying changes from your project config files ... done
php_1         | [01-Dec-2020 18:38:46] NOTICE: fpm is running, pid 22
php_1         | [01-Dec-2020 18:38:46] NOTICE: ready to handle connections
```

...and the following to indicate that the Vite container is ready:
```
vite_1        |   > Local:    http://localhost:3000/
vite_1        |   > Network:  http://172.28.0.3:3000/
vite_1        | 
vite_1        |   ready in 10729ms.
```

All of the Twig files, JavaScript, Vue components, CSS, and even the Vite config itself will relfect changes immediately Hot Module Replacement, so feel free to edit things and play around.

A password-scrubbed seed database will automatically be installed; you can log into the CP at `http://localhost:8000/admin` via these credentials:

**User:** `admin` \
**Password:** `password`

### Makefile Project Commands

This project uses Docker to shrink-wrap the devops it needs to run around the project.

To make using it easier, we're using a Makefile and the built-in `make` utility to create local aliases. You can run the following from terminal in the project directory:

- `make dev` - starts up the local dev server listening on `http://localhost:8000/`
- `make build` - builds the static assets via the Vite buildchain
- `make clean` - shuts down the Docker containers, removes any mounted volumes (including the database), and then rebuilds the containers from scratch
- `make update` - causes the project to update to the latest Composer and NPM dependencies
- `make update-clean` - completely removes `node_modules/` & `vendor/`, then causes the project to update to the latest Composer and NPM dependencies
- `make composer xxx` - runs the `composer` command passed in, e.g. `make composer install`
- `make craft xxx` - runs the `craft` [console command](https://craftcms.com/docs/3.x/console-commands.html) passed in, e.g. `make craft project-config/apply` in the php container
- `make npm xxx` - runs the `npm` command passed in, e.g. `make npm install`

### Things you can try

With the containers up and running, here are a few things you can try:

* Edit a CSS file such as `src/css/components/header.css` to add something like this, and change the colors to see the CSS change instantly via HRM:
```css
* {
  border: 3px solid red;
}
```

* Edit the `src/vue/Confetti.vue` vue component, changing the `defaultSize` and see your changes instantly via HMR (the slider will move)


### Other notes

To update to the latest Composer packages (as constrained by the `cms/composer.json` semvers) and latest npm packages (as constrained by the `buildchain/package.json` semvers), do:
```
make update
```

To start from scratch by removing `buildchain/node_modules/` & `cms/vendor/`, then update to the latest Composer packages (as constrained by the `cms/composer.json` semvers) and latest npm packages (as constrained by the `buildchain/package.json` semvers), do:
```
make update-clean
```

Here's the full, unmodified Europa Museum README.md from Pixel & Tonic:

<h1 align="center">Europa Museum Craft CMS Demo</h1>

![Europa Museum homepage](https://raw.githubusercontent.com/craftcms/europa-museum/HEAD/web/guide/homepage.png)

## Overview

The Europa Museum is a custom [Craft CMS](https://craftcms.com) marketing website for a fictitious art museum. This repository houses the source code for our demo, which you can spin up for yourself by visiting [craftcms.com/demo](https://craftcms.com/demo?kind=europa).

We’ve also included instructions below for setting up the demo in a local development environment with [Craft Nitro](https://getnitro.sh).

Europa shows off many of Craft’s core features and includes a guided tour courtesy of the [Guide](https://plugins.craftcms.com/guide) plugin.

### Development Technologies

- [Craft CMS 3](https://craftcms.com/docs/3.x/)
- PostgreSQL (11.5+) / MySQL (5.7+)
- PHP (7.2.5+), built on the [Yii 2 framework](https://www.yiiframework.com/)
- Native Twig templates

### Front End Dependencies

- [Babel](https://babeljs.io/) with ES6
- [Sass](https://sass-lang.com/)
- [Laravel Mix](https://github.com/JeffreyWay/laravel-mix#readme) with [PurgeCSS](https://github.com/spatie/laravel-mix-purgecss#readme) and [Critical CSS](https://github.com/riasvdv/laravel-mix-critical#readme)
- [Highway.js](https://highway.js.org/)
- [GSAP](https://greensock.com/gsap)
- [Lazysizes](https://github.com/aFarkas/lazysizes#readme)
- [LocomotiveScroll](https://github.com/locomotivemtl/locomotive-scroll)

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

- `npm run watch` to watch and automatically recompile assets for local development
- `npm run sync` to watch files and reload with BrowserSync for local development
- `npm run dev` to compile assets for local development
- `npm run prod` to compile optimized assets for production

## License

The source code of this project is licensed under the [BSD Zero Clause License](LICENSE.MD) unless stated otherwise.

The imagery used by this project is the property of each respective license holder. You are not free to use it for your own projects.
