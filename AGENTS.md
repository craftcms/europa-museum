# Agent guidance

## Uploads and image transforms

Files in `web/uploads/` are committed on purpose, including the image transforms Craft generates there (`_<width>x<height>_…` folders) when pages are rendered. Unlike a typical Craft project, do not ignore them.

Commit new or changed files in `web/uploads/` separately from other work, in their own commit with a message like `Adds new image transforms for demos`.

## Amp orbs

`.agents/setup` reads tool versions from `.ddev/config.yaml` (`php_version`, `database.version`, `composer_version`, and `nodejs_version`, falling back to the latest Node.js 24.x). Update versions there rather than in the setup script. `.nvmrc` is outdated and is not used.

Run the site with `amp orb services ensure`; `.amp/services.yaml` serves it with `php craft serve`.
