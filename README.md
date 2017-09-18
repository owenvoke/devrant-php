# devrant-php

[![Build Status](https://travis-ci.org/pxgamer/devrant-php.svg?branch=master)](https://travis-ci.org/pxgamer/devrant-php)

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

include 'src/Modules/*.php'; // Include whichever Modules that are required
```

Once included, you can initialise the class using either of the following:
```php
$module = new \pxgamer\devRant\Modules\*;
```
```php
use \pxgamer\devRant\Modules;
$module = new Modules\*;
```

## Class Methods

#### Modules\Account
Method Name           | Parameters | Returns
--------------------- | ---------- | -------
login($username, $password) | strings     | `boolean`
logout()              | void       | `void`
notifs() | void | `array`
deleteAccount() | void | `array`

#### Modules\Collabs
Method Name           | Parameters | Returns
--------------------- | ---------- | -------
collabs() | void | `array`

#### Modules\Comments
Method Name           | Parameters | Returns
--------------------- | ---------- | -------
comment($rantId, $comment) | mixed | `array`
voteComment($commentId, $vote) | mixed | `array`
deleteComment($commentId) | int | `array`

#### Modules\Rants
Method Name           | Parameters | Returns
--------------------- | ---------- | -------
rant($rant) | Rant object | `array`
deleteRant($rantId) | int | `array`
getRants($searchterm) | string (optional) | `array of Rant objects`
getRantById($id)      | int        | `Rant object`
voteRant($rantId, $vote) | mixed | `array`

#### Modules\Users
Method Name           | Parameters | Returns
--------------------- | ---------- | -------
getUserById($id)      | int        | `array`
getUserId($username) | string     | `array`

## Examples

### _Getting array of rants_
```php
$rants = new \pxgamer\devRant\Modules\Rants;
$rants->getRants(); // Get rants
$rants->getRants($searchterm); // Get rants using a search query
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
$rants = new \pxgamer\devRant\Modules\Rants;
$rants->getRantById(int);
```
Returns false on failure, or a `Rant` object.

### _Getting a user by their id_
```php
$users = new \pxgamer\devRant\Modules\Users;
$users->getUserById(int);
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
$rants = new \pxgamer\devRant\Modules\Rants;
$rants->getRants('string');
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
$users = new \pxgamer\devRant\Modules\Users;
$users->getUserId('username');
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
$account = new \pxgamer\devRant\Modules\Account;
$account->login('username', 'password');
```
Returns `true` if successful, `false` if not

### _Posting a rant_
```php
use \pxgamer\devRant\Rant;

$account = new \pxgamer\devRant\Modules\Account;
$rants = new \pxgamer\devRant\Modules\Rant;
if ($account->login('username', 'password')) {
    $rants->rant(new Rant($rant_content, $tags));
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
$account = new \pxgamer\devRant\Modules\Account;
$comments = new \pxgamer\devRant\Modules\Comments;
if ($account->login('username', 'password')) {
    $comments->comment($rantId, 'Comment Content');
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
$collabs = new \pxgamer\devRant\Modules\Collabs;

$response = $collabs->collabs();
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
$account = new \pxgamer\devRant\Modules\Account;
$rants = new \pxgamer\devRant\Modules\Rants;
if ($account->login('username', 'password')) {
    $voteRant = $rants->voteRant($rantId, $vote);
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
$accounts = new \pxgamer\devRant\Modules\Account;
$comments = new \pxgamer\devRant\Modules\Comments;
if ($accounts->login('username', 'password')) {
    $voteComment = $comments->voteComment($commentId, $vote);
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
$account = new \pxgamer\devRant\Modules\Account;
if ($account->login('username', 'password')) {
    $notifications = $account->notifs();
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
$account = new \pxgamer\devRant\Modules\Account;
$rants = new \pxgamer\devRant\Modules\Rants;
if ($account->login('username', 'password')) {
    $rants->deleteRant($rantId);
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
$account = new \pxgamer\devRant\Modules\Account;
$comments = new \pxgamer\devRant\Modules\Comments;
if ($account->login('username', 'password')) {
    $comments->deleteComment($commentId);
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
$account = new \pxgamer\devRant\Modules\Account;
if ($account->login('username', 'password')) {
    $account->deleteAccount();
}
```
Returns:
```php
[
    "success" => true
]
```
