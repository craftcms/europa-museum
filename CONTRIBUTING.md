# Contributing

## Reseed

Persistent changes to the content model or content in Europa Museum are made via updates to the seed database.

For Craft updates, this is done automatically on an ongoing basis on the repository for Craft updates. It should also be done for manual updates and content changes.

It’s best if you start with a fresh import of `seed.sql`, make only the changes you need, and then run:

```sh
craft db/backup seed.sql --overwrite 
```
