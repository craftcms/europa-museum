# Agent guidance

Follow [CONTRIBUTING.md](CONTRIBUTING.md) for contribution guidance.

## Front-end build artifacts, uploads, image transforms

There are files in `web/` that would not be committed in a typical Craft project, but they are not ignored and given dedicated commits in this project.

- After running `npm run prod`, commit new or changed files in `web/` separately from other work, in their own commit with a message like “Rebuild”.
- Files in `web/uploads/` are committed on purpose, downscaled to at most 2560px. The image transforms Craft generates there (`_<width>x<height>_…` folders) are ignored and regenerated on demand.

## Screenshots of the front-end

Images on the front-end are lazy-loaded with `lazysizes` (`.lazyload` elements with `data-srcset`), so a full-page screenshot of an unscrolled page shows blank gaps and broken-image alt text below the fold. `lazysizes` does trigger in headless browsers — but only when the page actually scrolls like a user would.

Before any screenshot (viewport or full-page), scroll through the page in steps, then return to the top and let images finish loading:

```bash
for i in $(seq 1 8); do agent-browser eval "window.scrollBy(0, 900)" > /dev/null; sleep 0.5; done
agent-browser eval "document.querySelectorAll('img.lazyload').length"   # expect 0
agent-browser eval "window.scrollTo(0, 0)" > /dev/null
sleep 2
agent-browser screenshot page.png --full
```

## Control panel

The seeded admin's password isn't public, so create your own with `php craft users/create --admin`.
