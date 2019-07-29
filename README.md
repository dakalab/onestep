# OneStep

PHP website based on Laravel 5.8 and adminLTE 2.4

## Quick Start

```
make up
```

Visit http://localhost:8080

## Compile js and css

Install node modules by `make yarn c=install`

After you modify js and css files, run `make yarn`

You can run yarn directly if you have it installed on local.

## Stop and clean up

Stop nginx and mariadb:

```
make down
```

Remove the data:

```
make prune-data
```
