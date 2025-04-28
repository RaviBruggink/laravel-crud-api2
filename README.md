# 🌌 Interstellar Agency - Space Mission CRUD API

Dit is een REST API-project gebouwd in Laravel om ruimtevaartmissies te beheren. Je kunt missies creëren, lezen, bijwerken en verwijderen (CRUD). Hieronder staan instructies hoe je het project kunt opzetten na het klonen.

## 🚀 Project opzetten

Volg deze stappen om het Laravel-project lokaal werkend te krijgen:

### 1. 📥 Clone de repository
```bash
git clone <repo_url>
cd <repo_map>
```

### 2. 🐳 Laravel Sail opstarten

Het project gebruikt Laravel Sail voor Docker-gebaseerde development. Zorg ervoor dat je Docker geïnstalleerd hebt.

Start vervolgens Sail:
```bash
./vendor/bin/sail up -d
```

> Geen zin om steeds `./vendor/bin/sail` te typen? Maak een alias:
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

### 3. ⚙️ Composer dependencies installeren
```bash
sail composer install
```

### 4. 🗄️ .env-bestand aanmaken

Maak een `.env`-bestand aan vanuit het voorbeeld:
```bash
cp .env.example .env
```

Genereer een applicatiesleutel:
```bash
sail artisan key:generate
```

### 5. 💾 Database migraties draaien
```bash
sail artisan migrate
```

> Optioneel: Vul de database met testdata:
```bash
sail artisan db:seed
```

## 🌐 API Routes

Alle API-routes zijn gedefinieerd in `routes/api.php` en beveiligd met API-key middleware.

Basis API-endpoints:

| Methode | URL               | Beschrijving              |
|---------|-------------------|---------------------------|
| GET     | /api/missions     | Lijst van alle missies    |
| POST    | /api/missions     | Maak een nieuwe missie    |
| GET     | /api/missions/{id}| Toon details van een missie|
| PUT     | /api/missions/{id}| Werk een missie bij       |
| DELETE  | /api/missions/{id}| Verwijder een missie      |

## 🔑 Authenticatie

Stuur in elke API-aanvraag de API-key mee in de header:
```
Authorization: Bearer JOUW_API_KEY
```

## 🧪 Testen
Gebruik CURL of Postman om je API-endpoints te testen.

Voorbeeld met CURL:
```bash
curl -H "Authorization: Bearer JOUW_API_KEY" -X GET http://localhost/api/missions
```

## 📖 Documentatie
Check altijd [Laravel Docs](https://laravel.com/docs) voor verdere uitleg over het framework en best practices.

