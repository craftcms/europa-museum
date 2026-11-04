# Agent guidance

## Front-end build artifacts, uploads, image transforms

There are files in `web/` that would not be committed in a typical Craft project, but they are not ignored and given dedicated commits in this project.

- After running `npm run prod`, commit new or changed files in `web/` separately from other work, in their own commit with a message like “Rebuild”.
- Files in `web/uploads/` are committed on purpose, including the image transforms Craft generates there (`_<width>x<height>_…` folders) when pages are rendered. Commit new or changed files in `web/uploads/` separately from other work, in their own commit with a message like “Adds new image transforms”.

## Amp orbs

`.agents/setup` reads tool versions from `.ddev/config.yaml` (`php_version`, `database.version`, `composer_version`, and `nodejs_version`, falling back to the latest Node.js 24.x). Update versions there rather than in the setup script. `.nvmrc` is outdated and is not used.

Run the site with `amp orb services ensure`; `.amp/services.yaml` serves it with `php craft serve`.
