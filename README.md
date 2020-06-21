# iPresence example

## Requirements:

* PHP 7.3

## Setup

* `composer install`

## Application

* `API Platform` is used for base API
* API documentation is on `/api` URL
* Basic usage:

POST request to `/api/shouts`

```
{
  "author": "Albert Einstein",
  "amount": 2
}
```

Response JSON:

```
[
    "STRIVE NOT TO BE A SUCCESS, BUT RATHER TO BE OF VALUE!",
    "A PERSON WHO NEVER MADE A MISTAKE NEVER TRIED ANYTHING NEW!"
]
```

## Tests

* `php bin/phpunit`
* `vendor/bin/phpstan analyse`
* `vendor/bin/ecs check`

## Known issues:

* It would be better to save data from API (simulated by quotes.json) and perform basic things after downloading data.
* No logic for clearing cache.
* API Platform supports caching by default, implemented solution is only an example.
* Caching headers missing (`max_age` etc.).
* `AuthorRepository` works with 1 API only.
* Tests cover only basic functionality.
* API Platform's validating messages should be unified with other messages.
