# Harmonie Šternberk

New (work in progress) Webpage/SPA for [Harmonie Šternberk orchestra](http://harmonie-sternberk.cz/).

#

## Project Setup

```sh
$ npm install
```

### Run without php functionality

```sh
$ npm run dev
```

### Run with docker-compose (with database and PHP functionality)

```sh
$ docker-compose -f "harmonie-web/docker-compose.yml" up -d --build

$ npm run build
# or
$ npm run watch
```
