## Installing

## Docker

Install [Docker](https://www.docker.com/get-started)

### Environment

Copy .env.example to .env and configurate .env

```
DB_PASSWORD=StronG_db_passw0rd // Use a strong password for mssql with special symbols, numbers, and uppercase symbols
DB_PORT=1433 // Database port
PUBLIC_IP=this.your.server.ip // IP server
EXP_RATE=100 // Enter EXP rate multiplier, e.g. 5 for 5x 
SEXP_RATE=100 // Enter Skill EXP rate multiplier
CEXP_RATE=100 // Enter Craft EXP rate multiplier
DROP_RATE=2 // Enter drop rate multiplier (over 5 is bad)
ALZ_RATE=100 // Enter Alz rate multiplier
BALZ_RATE=100 // Enter Alz bomb rate multiplier
PEXP_RATE=100 // Enter Pet EXP multiplier
ITEMS_PER_DROP=2 // Enter number of items per drop
CONFIG_TYPE=1
```

#### CONFIG_TYPE
```
1 - Mercury (1 chan. Premium)
2 - Venus  (1 chan. PK)
3 - Mars (1 chan. War)
4 - Jupiter (1 chan. Tierra Gloriosa)
5 - Saturn (2 chan. Normal/TG)
6 - Neptune (3 chan. Normal/War/Tierra Gloriosa)
7 - Pluto (3 chan. PK/War/Tierra Gloriosa)
8 - Leo (4 chan. Normal/PK/Prem War/Tierra Gloriosa)
9 - Sirius (4 chan. Normal/PK/War/Tierra Gloriosa)
10 - Draco (5 chan. Normal/Prem/Prem PK/Prem War/TG)
11 - Test Server (1 chan. PK)
12 - Duality (2 server, 1 norm and 1 War channel) DONT WORK STABLE
20 - Divinity (3 server, 1 norm and 1 PK channel each) DONT WORK STABLE
```

Otherwise, your container will not start.

## Build containers
```cmd
docker-compose build
```
## Database

Up container
```cmd
docker-compose up -d mssql
```

Restore database
```cmd
docker-compose exec mssql sh restoredb.sh
```
default registered user 
username "admin" password "admin"
## Server

Start server
```cmd
docker-compose up -d server
```
```cmd
docker-compose exec server sh /home/cabal/cabal_config.sh
```
### Stop server
```cmd
docker-compose down server
```
### Service logs

```cmd
server/logs
```

### GM panel/Register Account http://localhost
```cmd
docker-compose up -d --build site nginx
docker-compose exec site composer install --no-cache
docker-compose exec site php artisan migrate --force
docker-compose exec site php artisan st:li
```