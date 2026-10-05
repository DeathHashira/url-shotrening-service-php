# URL Shortening Service API - PHP
A simple URL shortening service API impelemented with raw PHP.

## Installation instruction
1. Clone the repo or download the zip file and go to the root directory of project.
2. Install all required packages (first make sure you have php and composer installed).
```bash
composer install
```
3. Create your `.env` file based on `.env.example` and add your database informations in it.
4. Add migrations to your database.
```bash
./vendor/bin/doctrine-migrations migrate
```
5. Run it in your localhost and now you can use API. You can choose whichever port you want (default 8000).
```bash
php -S localhost:<port> -t public/
```
## API Documentary
This API is for creating short links for urls. \
This API contains only one model. A url represents each url added to database with a given short link to it. 
\
Base URL: localhost:port (The port you have set) \
And the protocol is HTTP.\
There's no `Authentication` needed for this API.

### 1. POST localhost:8000/shorten
Add new url to database.\
**Request Body:**
| Field | Type | Required | Description |
|---|---|---|---|
|url|string|yes|-|

```bash
curl -X localhost:8000/shorten \
-d '{
    "url": "google.com"
}'
```

<details>
<summary>201 Response Example</summary>
Returns the short_code that references to the given url.
{"short_code": "fjklaedk"}
</details>
<details>
<summary>400 Response Example</summary>
Error in the database setup.
</details>

### 2. GET localhost:8000/shorten/{shortCode}
Get the url for the short code.\

```bash
curl localhost:8000/shorten/fjklaedk
```

<details>
<summary>200 Response Example</summary>
{
    "id": "1",
    "url": "google.com",
    "short_code": "fjklaedk",
    "created_at": "2026-10-05 15:04:11"
    "updated_at": "2026-10-05 15:04:11",
    "stats": 10
}
</details>
<details>
<summary>400 Response Example</summary>
Error from database setup.
</details>
<details>
<summary>404 Response Example</summary>
Short code doesn't exist.
</details>

### 3. PATCH localhost:8000/shorten/{shortCode}
Update url of the given short code.\
**Request Body**
| Field | Type | Required | Description |
|---|---|---|---|
|url|string|yes|new url for replacing old one|

```bash
curl -X PATCH localhost:8000/shorten/fdkldess \
-d '{
    "url": "spotify.com"
}'
```

<details>
<summary>200 Response Example</summary>
No content.
</details>
<details>
<summary>400 Response Example</summary>
Error in database setup.
</details>
<details>
<summary>404 Response Example</summary>
The short code doesn't exist.
</details>

### 4. DELETE localhost:8000/shorten/{shortCode}
Delete the existing url from database.\

```bash
curl -X DELETE localhost:8000/shorten/jjertc43
```

<details>
<summary>204 Response Example</summary>
Successful delete.
</details>
<details>
<summary>404 Response Example</summary>
The short code doesn't exist.
</details>
<details>
<summary>400 Response Example</summary>
Error in database setup.
</details>

### 5. GET localhost:8000/shorten/{shortCode}/stats
Get the statics (number of short code is visited).\

```bash
curl localhost:8000/shorten/jfkaljsd/stats
```

<details>
<summary>200 Response Example</summary>
{
    "id": "1",
    "url": "google.com",
    "short_code": "fjklaedk",
    "created_at": "2026-10-05 15:04:11"
    "updated_at": "2026-10-05 15:04:11",
    "stats": 10
}
</details>
<details>
<summary>404 Response Example</summary>
The short code doesn't exist.
</details>
<details>
<summary>400 Response Example</summary>
Error in database setup.
</details>

## Usage
This project is only customized for practical usage and training projects. Also dynamic routing is implemented in this project with a standard structure and also will get better.

Note: The idea of this project is from [Roadmap.sh projects](https://roadmap.sh/projects/url-shortening-service).

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.