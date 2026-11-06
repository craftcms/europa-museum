# Contributing

## Reseed

Persistent changes to the Craft version, content model, content in Europa Museum are made via updates to the seed database.

It’s best if you start with a fresh import of `seed.sql`, make only the changes you need, and then run:

```sh
craft db/backup seed.sql --overwrite 
```
