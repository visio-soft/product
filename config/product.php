<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | The user model that will be used for ideas and comments.
    |
    */
    'user_model' => env('PRODUCT_USER_MODEL', 'App\\Models\\User'),

    /*
    |--------------------------------------------------------------------------
    | Ideas Table Name
    |--------------------------------------------------------------------------
    |
    | The table name for ideas.
    |
    */
    'ideas_table' => 'ideas',

    /*
    |--------------------------------------------------------------------------
    | Comments Table Name
    |--------------------------------------------------------------------------
    |
    | The table name for idea comments.
    |
    */
    'comments_table' => 'idea_comments',

    /*
    |--------------------------------------------------------------------------
    | Enable Reactions
    |--------------------------------------------------------------------------
    |
    | Enable user reactions to ideas (likes, upvotes, etc).
    |
    */
    'enable_reactions' => true,

    /*
    |--------------------------------------------------------------------------
    | Importance Levels
    |--------------------------------------------------------------------------
    |
    | Define the importance levels for ideas.
    |
    */
    'importance_levels' => [
        'not_important' => 'Not important',
        'nice_to_have' => 'Nice-to-have',
        'important' => 'Important',
        'critical' => 'Critical',
    ],
];
