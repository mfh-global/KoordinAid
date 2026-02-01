# KoordinAid

Vorläufiger Name.

Weiterentwicklung des HERMINE Internen IZ-Tools mit dem Ziel, anfragen für Hilfsgüter zusammen mit anderen Organisationen zu Koordinieren.

## Tech-Stack
- Laravel
- MySQL
- VueJS

## Setup

### Kopiere die .env.example -> .env
Wichtig ist es ein DB_PASSWORD festzulegen

### Installation der Dependencies

Mit docker
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Mit PHP 8.3
```bash
composer require laravel/sail --dev
```
```bash
php artisan sail:install
```

### Startup
```bash
./vendor/bin/sail up
```

### App key generieren
```
./vendor/bin/sail artisan key:generate
```

### Initialisieren/Refresh der Datenbank Tabellen
```
./vendor/bin/sail artisan migrate:refresh --seed
```

### Indizieren von Documenten in Meilisearch
```
./vendor/bin/sail artisan scout:import App\\Models\\Product
```

### Installieren/Aktualisieren der composer dependencies anhand der composer.lock file
```
./vendor/bin/sail composer install  
```

### npm install
```
./vendor/bin/sail npm install
```

### run vite development server
```
./vendor/bin/sail npm run dev
```

### create a alias for sail
```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

### importing data
```
artisan command:import-boxtribute-products
artisan command:import-boxtribute-locations
```
