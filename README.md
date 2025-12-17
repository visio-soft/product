# Product - FilamentPHP Module

A simple and clean FilamentPHP module for team discussions and idea submissions. This module enables teams to collaborate, submit new ideas, and interact with each other's suggestions.

## Features

- 💡 **Idea Management**: Submit and manage product ideas
- 🎯 **Importance Levels**: Categorize ideas (Not important, Nice-to-have, Important, Critical)
- 💬 **Comments**: Discuss ideas with team members
- ❤️ **Reactions**: Show support for ideas with reactions
- 👥 **User Interactions**: Engage with other users' ideas
- 🔍 **Search & Filter**: Easily find ideas by title, description, importance, or user
- 🗑️ **Soft Deletes**: Safely delete and restore ideas and comments

## Requirements

- PHP 8.2 or higher
- Laravel 10.x or 11.x
- FilamentPHP 4.x

## Installation

You can install the package via composer:

```bash
composer require visio/product
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="product-migrations"
php artisan migrate
```

Optionally, you can publish the config file:

```bash
php artisan vendor:publish --tag="product-config"
```

## Configuration

The configuration file `config/product.php` allows you to customize:

- User model
- Table names
- Enable/disable reactions
- Importance levels

Example configuration:

```php
return [
    'user_model' => env('PRODUCT_USER_MODEL', 'App\\Models\\User'),
    'ideas_table' => 'ideas',
    'comments_table' => 'idea_comments',
    'enable_reactions' => true,
    'importance_levels' => [
        'not_important' => 'Not important',
        'nice_to_have' => 'Nice-to-have',
        'important' => 'Important',
        'critical' => 'Critical',
    ],
];
```

## Usage

### Registering the Plugin

Register the resources in your Filament panel provider:

```php
use Visio\Product\Filament\Resources\IdeaResource;
use Visio\Product\Filament\Resources\IdeaCommentResource;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->resources([
            IdeaResource::class,
            IdeaCommentResource::class,
        ]);
}
```

### Creating Ideas

Users can create ideas with the following information:

- **Title**: Brief description of the idea
- **Description**: Detailed explanation
- **Importance**: How important is this idea? (Not important, Nice-to-have, Important, Critical)
- **Context**: Why is this needed? Additional context to help understand the value

### Interacting with Ideas

- **View Details**: Click on any idea to see full details
- **Add Comments**: Share thoughts and feedback on ideas
- **React**: Show support by adding reactions
- **Filter & Search**: Find specific ideas using filters and search

### Managing Comments

- Comments are displayed on the idea view page
- Users can add, edit, and delete their comments
- Comments support soft deletes for data recovery

## Models

### Idea Model

```php
use Visio\Product\Models\Idea;

// Create an idea
$idea = Idea::create([
    'title' => 'New Feature Request',
    'description' => 'We need this feature...',
    'importance' => 'important',
    'context' => 'This would help us...',
    'user_id' => auth()->id(),
]);

// Add a reaction
$idea->incrementReactions();

// Get comments
$comments = $idea->comments;
```

### IdeaComment Model

```php
use Visio\Product\Models\IdeaComment;

// Create a comment
$comment = IdeaComment::create([
    'idea_id' => $idea->id,
    'user_id' => auth()->id(),
    'comment' => 'Great idea! I suggest...',
]);
```

## Importance Levels

The module includes four importance levels with visual badges:

- 🔵 **Not important** (Gray badge)
- 💙 **Nice-to-have** (Info/Blue badge)
- ⚠️ **Important** (Warning/Yellow badge)
- 🔴 **Critical** (Danger/Red badge)

## Database Structure

### Ideas Table

- `id`: Primary key
- `title`: Idea title
- `description`: Detailed description
- `importance`: Importance level
- `context`: Additional context
- `user_id`: Idea creator
- `reactions_count`: Number of reactions
- `created_at`, `updated_at`, `deleted_at`

### Idea Comments Table

- `id`: Primary key
- `idea_id`: Reference to idea
- `user_id`: Comment author
- `comment`: Comment text
- `created_at`, `updated_at`, `deleted_at`

## Testing

```bash
composer test
```

## Code Formatting

```bash
composer format
```

## License

MIT License

## Credits

- **Visio Soft**

## Support

For support, please open an issue on GitHub.
