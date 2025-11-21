## Craft 5.9

- Entrified news categories
- Rearranged entry sources into pages
- `PRIMARY_SITE_URL` > `DEFAULT_SITE_URL`
- Renamed filesystems to match their storage medium rather than usage
- Removed `@web` alias
- `@assetBaseUrl` split into `@uploads` and `@dist`, simplified asset URL schemes:
    - Moved uploaded assets into `web/uploads/` (`@uploads`)
    - Moved build artifacts into `web/assets/disc/` (`@dist`)
    - Rearranged URLs and paths in filesystem/volume config
- Renamed `FS_HANDLE` to `UPLOAD_FS` for switching filesystem types
- Converted CTA/link blocks to use the link field
- Removed unused tag group
- Merged redundant ex-Matrix fields
- Removed French site (there was no content for this, anyway—and the homepage didn't resolve)

### To-Do

- Add `cache` table to seed, or add `craft setup/db-cache-table` to Makefile/setup instructions
- Add `phpsessions` table to seed, or add `craft setup/php-session-table` to Makefile/setup instructions

## Cleanup

- Alter `craftcms/cms` constraint to `^5.9.0` upon release
- Delete all content migrations created during field merging!
- Prune dead project config files + items
- `config/debug.php`?
