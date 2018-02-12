# Recipes API

Simple Recipe API using Laravel as it's quick to setup and has REST friendly features.

Not implemented, but to support returning different JSON depending on the client or the user role, I would research something around the `setVisible`/`setHidden` methods on models to show/hide properties based on the user role, a custom header or other conditions. Other serializers such as JMS allow serialization groups for this purpose but this can be cumbersome to maintain so I'd investigate other approaches beforehand. 

Other suggested improvements are listed below 

## Setup

I was using Laravel Homestead but can theoretically run using Laravel's `php artisan serve`, though I'm using Sqlite which I couldn't get to work on my Windows host due to the path. 

    cp .env.example .env # change sqlite path as needed
    php artisan migrate:fresh
    php artisan db:seed


### Example endpoints

Paginated Index:
http://recipes.test/api/recipes

Paginated Index filtered by `cuisine`:
http://recipes.test/api/recipes?cuisine=british

Single Recipe:
http://recipes.test/api/recipes/1
    
    
## Improvements

- Validate data when creating/updating recipes
- Authentication on routes e.g. prevent non-admin users from editing recipes
- Return different json depending on user role