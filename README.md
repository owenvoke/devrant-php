# devrant-php

A simple PHP wrapper for utilising the [devRant](https://devrant.io) api.

## Usage

__Include the class:__
- Using Composer

`composer require pxgamer/devrant-php`
```php
<?php
require 'vendor/autoload.php';
```

- Including the file manually
```php
<?php
include 'src/Connection.php';
```

Once included, you can initialise the class using either of the following:
```php
$devRant = new \pxgamer\devRant\Connection;
```
```php
use \pxgamer\devRant\Connection;
$devRant = new Connection;
```

## Class Methods

Method Name           | Parameters | Returns
--------------------- | ---------- | -------
getRants()            | void       | `string (json)`
getRantById($id)      | int        | `string (json)`
getUserById($id)      | int        | `string (json)`
searchRants($query)   | string     | `string (json)`
getUsersId($username) | string     | `string (json)`
login($username, $password) | strings     | `boolean`
logout()              | void       | `void`
postNewRant($rant_content, $tags) | strings | `string (json)`

## Examples

### _Getting array of rants_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getRants();
```
Returns:
```json
{
    "success": true,
    "rants": [
    ]
}
```

### _Getting a single rant by its id_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getRantById(int);
```
Returns:
```json
{
    "rant": {
    },
    "comments": [
    ],
    "success": true
}
```

### _Getting a user by their id_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getUserById(int);
```
Returns:
```json
{
    "success": true,
    "profile": {
        "username": "",
        "score": 0,
        "about": "",
        "location": "",
        "created_time": 1474613872,
        "skills": "",
        "github": "",
        "website": "",
        "content": {
            "content": {
                "rants": [],
                "upvoted": [],
                "comments": [],
                "favorites": []
            },
            "counts": {}
        },
        "avatar": {}
    }
}
```

### _Search rants_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->searchRants('string');
```
Returns:
```json
{
    "success": true,
    "results": [
        {
            "id": 0,
            "text": "string",
            "num_upvotes": 0,
            "num_downvotes": 0,
            "score": 0,
            "created_time": 0,
            "attached_image": {
                "url": "string",
                "width": 0,
                "height": 0
            },
            "num_comments": 0,
            "tags": [
                "string"
            ],
            "vote_state": 0,
            "edited": false,
            "user_id": 0,
            "user_username": "string",
            "user_score": 0,
            "user_avatar": {
                "b": "string"
            }
        }
    ]
}
```

### _Getting a user's id from their username_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getUsersId('string');
```
Returns:
```json
{
    "success": true,
    "user_id": 0
}
```

### _Getting signed in_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->login('username', 'password');
```
Returns `true` if successful, `false` if not

### _Posting a rant_
```php
$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $devRant->postNewRant($rant_content, $tags);
}
```
Returns:
```json
{
    "success": true,
    "rant_id": 31131
}
```
