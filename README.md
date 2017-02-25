# devrant-php

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PXgamer/devrant-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PXgamer/devrant-php/?branch=master) [![Build Status](https://travis-ci.org/PXgamer/devrant-php.svg?branch=master)](https://travis-ci.org/PXgamer/devrant-php)

A simple PHP wrapper for utilising the [devRant](https://devrant.io) api.

## Usage

__Include the class:__
- Using Composer

`composer require pxgamer/devrant-php`
```php
<?php
require 'vendor/autoload.php';
```

- Including the files manually
```php
<?php
include 'src/Connection.php';
include 'src/Rant.php';
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
getRants($searchterm) | string (optional) | `array of Rant objects`
getRantById($id)      | int        | `Rant object`
getUserById($id)      | int        | `array`
getUsersId($username) | string     | `array`
login($username, $password) | strings     | `boolean`
logout()              | void       | `void`
rant($rant) | Rant object | `array`
comment($rantId, $comment) | mixed | `array`
voteRant($rantId, $vote) | mixed | `array`
voteRant($commentId, $vote) | mixed | `array`
notifs() | void | `array`
collabs() | void | `array`
deleteRant($rantId) | int | `array`
deleteComment($commentId) | int | `array`
deleteAccount() | void | `array`

## Examples

### _Getting array of rants_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getRants(); // Get rants
$devRant->getRants($searchterm); // Get rants using a search query
```
Returns false on failure, or:
```php
[
    0 => Rant object,
    1 => Rant object,
    ...
]
```

### _Getting a single rant by its id_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getRantById(int);
```
Returns false on failure, or a `Rant` object.

### _Getting a user by their id_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getUserById(int);
```
Returns:
```php
[
    "success" => true,
    "profile" => [
        "username" => "",
        "score" => 0,
        "about" => "",
        "location" => "",
        "created_time" => 1474613872,
        "skills" => "",
        "github" => "",
        "website" => "",
        "content" => [
            "content" => [
                "rants" => [],
                "upvoted" => [],
                "comments" => [],
                "favorites" => []
            [,
            "counts" => []
        ],
        "avatar" => []
    ]
]
```

### _Search rants_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getRants('string');
```
Returns false on failure, or:
```php
[
    0 => Rant object [
        "id" => 0,
        "text" => "string",
        "num_upvotes" => 0,
        "num_downvotes" => 0,
        "score" => 0,
        "created_time" => 0,
        "attached_image" => [
            "url" => "string",
            "width" => 0,
            "height" => 0
        ],
        "num_comments" => 0,
        "tags" => [
            "string"
        ],
        "vote_state" => 0,
        "edited" => false,
        "user_id" => 0,
        "user_username" => "string",
        "user_score" => 0,
        "user_avatar" => [
            "b" => "string"
        ]
    ],
    1 => Rant object,
    ...
]
```

### _Getting a user's id from their username_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->getUserId('username');
```
Returns:
```php
[
    "success" => true,
    "user_id" => 0
]
```

### _Getting signed in_
```php
$devRant = new \pxgamer\devRant\Connection;
$devRant->login('username', 'password');
```
Returns `true` if successful, `false` if not

### _Posting a rant_
```php
use \pxgamer\devRant\Rant;

$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $devRant->rant(new Rant($rant_content, $tags));
}
```
Returns:
```php
[
    "success" => true,
    "rant_id" => 31131
]
```

### _Posting a comment_
```php
$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $devRant->comment($rantId, 'Comment Content');
}
```
Returns:
```php
[
    "success" => true
]
```

### _Getting Collabs_
```php
$devRant = new \pxgamer\devRant\Connection;

$collabs = $devRant->collabs();
```
Returns:
```php
[
    "success" => true,
    "rants" => [
		[0] => [
		    ...
		]
	]
]
```

### _Voting on Rants_
```php
$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $voteRant = $devRant->voteRant($rantId, $vote);
}
```
Returns:
```php
[
    "success" => true,
    "rant" => [
		[id] => ...,
		...
	]
]
```

### _Voting on Comments_
```php
$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $voteRant = $devRant->voteRant($rantId, $vote);
}
```
Returns:
```php
[
    "success" => true,
    "comment" => [
		[id] => ...,
		...
	]
]
```

### _Getting your notifications_
```php
$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $notifications = $devRant->notifs();
}
```
Returns:
```php
[
    "success" => true,
    "data" => {
		"items" => [
			...
		],
		"check_time" => 11111,
		"username_map" => {
			...
		}
	}
]
```

### _Deleting a rant_

*Please note that this will __permanently__ delete the rant from devRant.*

```php
$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $devRant->deleteRant($rantId);
}
```
Returns:
```php
[
    "success" => true
]
```

### _Deleting a comment_

*Please note that this will __permanently__ delete the comment from devRant.*

```php
$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $devRant->deleteComment($commentId);
}
```
Returns:
```php
[
    "success" => true
]
```

### _Deleting your account_

*Please note that this will __permanently__ delete your account from devRant.*

```php
$devRant = new \pxgamer\devRant\Connection;
if ($devRant->login('username', 'password')) {
    $devRant->deleteAccount();
}
```
Returns:
```php
[
    "success" => true
]
```
