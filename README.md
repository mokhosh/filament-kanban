# Add kanban boards to your Filament pages

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mokhosh/filament-kanban.svg?style=flat-square)](https://packagist.org/packages/mokhosh/filament-kanban)
[![Total Downloads](https://img.shields.io/packagist/dt/mokhosh/filament-kanban.svg?style=flat-square)](https://packagist.org/packages/mokhosh/filament-kanban)


Easily add Kanban board pages to your Filament panels.

![Customized kanban board views](https://raw.githubusercontent.com/mokhosh/filament-kanban/main/images/client-kanban.png)

![Customized edit modal](https://raw.githubusercontent.com/mokhosh/filament-kanban/main/images/client-edit.png)

![Cards with progress indicator](https://raw.githubusercontent.com/mokhosh/filament-kanban/main/images/prospect-kanban.png)

![Another example by @Log1x](https://raw.githubusercontent.com/mokhosh/filament-kanban/main/images/organizer-board.png)

## Installation

You can install the package via composer:

```bash
composer require mokhosh/filament-kanban
```

Publish the assets so the styles are correct:

```bash
php artisan filament-kanban:install
```

## Before You Start

> [!IMPORTANT]  
> You should have some `Model` with a `status` column. This column can be called `status` in the database or anything else.

I'm also assuming there's a `title` column on your model, but you can have `name` or any other column to represent a title.

I recommend you create a string backed `Enum` to define your statuses.

You can use our `IsKanbanStatus` trait, so you can easily transform your enum cases for the Kanban board using the `statuses` method on your enum.

```php
use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum UserStatus: string
{
    use IsKanbanStatus;

    case User = 'User';
    case Admin = 'Admin';
}
```

I recommend you cast the `status` attribute on your `Model` to the enum that you have created.

> [!TIP]
> I also recommend you use the [Spatie Eloquent Sortable](https://github.com/spatie/eloquent-sortable) package on your `Model`, and we will magically add sorting abilities to your Kanban boards.

## Usage

You can create a new Kanban board called `UsersKanbanBoard` using this artisan command:

```php
php artisan make:kanban UsersKanbanBoard
```

This creates a good starting point for your Kanban board. You can customize the Kanban board to your liking.

You should override the `model` property, so we can load your records.

```php
protected static string $model = User::class;
```

You should also override the `statusEnum` property, which defines your statuses.

```php
protected static string $statusEnum = UserStatus::class;
```

## Upgrade Guide

If you have version 1.x on your application, and you want to upgrade to version 2.x, here is your checklist:

- [ ] You need to override `$model` and `$statusEnum` as mentioned in [the last part](#usage)
- [ ] If you have published `kanban-record.blade.php` view, you can use `$record` as a `Model` instance instead of an `array`.
- [ ] If you're overriding `KanbanBoard` methods just to do the default behaviour, you can safely remove them now. You should be able to get away with overriding 0 methods, if you don't have special requirements 🥳

## Advanced Usage

You can override the `records` method, to customize how the records or items that you want to see on your board are retrieved.

```php
protected function records(): Collection
{
    return User::where('role', 'admin')->get();
}
```

If you don't want to define an `Enum` for your statuses, or you have a special logic for retrieving your statuses, you can override the `statuses` method:

```php
protected function statuses(): Collection
{
     return collect([
         ['id' => 'user', 'title' => 'User'],
         ['id' => 'admin', 'title' => 'Admin'],
     ]);
}
```

You can also override these methods to change your board's behavior when records are dragged and dropped:
- `onStatusChanged` which defines what happens when a record is moved between statuses.
- `onSortChanged` which defines what happens when a record is moved inside the same status.

```php
public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
{
    User::find($recordId)->update(['status' => $status]);
    User::setNewOrder($toOrderedIds);
}

public function onSortChanged(int $recordId, string $status, array $orderedIds): void
{
    User::setNewOrder($orderedIds);
}
```

### Customizing the Status Enum

If you add `IsKanbanStatus` to your status `Enum`, this trait adds a static `statuses()` method to your enum that will return the statuses defined in your enum in the appropriate format.

If you don't want all cases of your enum to be present on the board, you can override this method and return a subset of cases:

```php
public static function kanbanCases(): array
{
    return [
        static::CaseOne,
        static::CaseThree,
    ];
}
```

`IsKanbanStatus` uses the `value` of your cases for the `title` of your statuses. You can customize how the title is retrieved as well:

```php
public function getTitle(): string
{
    return __($this->label());
}
```

## Edit modal

### Disabling the modal

Edit modal is enabled by default, and you can show it by clicking on records.

If you need to disable the edit modal override this property:

```php
public bool $disableEditModal = false;
```

### Edit modal form schema

You can define the edit modal form schema by overriding this method:

```php
protected function getEditModalFormSchema(null|int $recordId): array
{
    return [
        TextInput::make('title'),
    ];
}
```

As you can see you have access to the `id` of the record being edited, if that's helpful in building your schema.

### Customizing edit form submit action

You can define what happens when the edit form is submitted by overriding this method:

```php
protected function editRecord($recordId, array $data, array $state): void
{
    Model::find($recordId)->update([
        'phone' => $data['phone']
    ]);
}
```

The `data` array contains the form data, and the `state` array contains the full record data.

### Customizing modal's appearance

You can customize modal's title, size and the labels for save and cancel buttons, or use Filament's slide-over instead of a modal:

```php
protected string $editModalTitle = 'Edit Record';

protected string $editModalWidth = '2xl';

protected string $editModalSaveButtonLabel = 'Save';

protected string $editModalCancelButtonLabel = 'Cancel';

protected bool $editModalSlideOver = true;
```

## Customization

### Changing the navigation icon

```php
protected static ?string $navigationIcon = 'heroicon-o-document-text';
```

### Changing the model property that's used as the title

```php
protected static string $recordTitleAttribute = 'title';
```

### Changing the model property that's used as the status

```php
protected static string $recordStatusAttribute = 'status';
```

### Customizing views

You can publish the views using this artisan command:

```bash
php artisan vendor:publish --tag="filament-kanban-views"
```

I recommend you delete the files that you don't intend to customize and keep the ones you want to change.
This way you will get any possible future updates for the original views.

The above method will replace the views for all Kanban boards in your applications.

Alternatively, you might want to change views for one of your boards. You can override each view by overriding these properties:

```php
protected static string $view = 'filament-kanban::kanban-board';

protected static string $headerView = 'filament-kanban::kanban-header';

protected static string $recordView = 'filament-kanban::kanban-record';

protected static string $statusView = 'filament-kanban::kanban-status';

protected static string $scriptsView = 'filament-kanban::kanban-scripts';
```

### Flashing Recently Updated Records

You get some visual feedback when a record has been just updated.

If you're also using [Spatie Eloquent Sortable](https://github.com/spatie/eloquent-sortable) you might experience all records being flashed at the same time. This is because [Eloquent Sortable](https://github.com/spatie/eloquent-sortable) updates the `order_column` of all models when the sort changes.
In order to fix that, publish their config and set `ignore_timestamps` to `true`.

## Video Tutorial

Are you a visual learner? I have created some Youtube videos to get you started with the package:

> [!WARNING]
> These videos are recorded with version 1.x of the package.
> It is now much simpler to use the package, and requires much less code from you.
> 
> Hopefully, version 2.x is simple enough to not require videos, but you can still learn a thing or two from these.

[![Creating a Kanban Board in FilamentPHP using filament-kanban: Part 1, Basic setup](https://i3.ytimg.com/vi/GquNTj50E78/maxresdefault.jpg)](https://www.youtube.com/watch?v=GquNTj50E78)

[![Creating a Kanban Board in FilamentPHP: Part 2, Sorting Records with Spatie Eloquent Sortable](https://i3.ytimg.com/vi/ySPx13VZ35s/maxresdefault.jpg)](https://www.youtube.com/watch?v=ySPx13VZ35s)

[![Creating a Kanban Board in FilamentPHP: Part 3, Multiple Kanban boards per model and customizations](https://i3.ytimg.com/vi/Pk-yZIrHTiQ/maxresdefault.jpg)](https://www.youtube.com/watch?v=Pk-yZIrHTiQ)

[![Create a Kanban Task Management App in 15 Minutes: Part 4, Create and Edit Actions](https://i3.ytimg.com/vi/QZP57DBtXrU/maxresdefault.jpg)](https://www.youtube.com/watch?v=QZP57DBtXrU)

[![Create a Kanban Task Management App with FilamentPHP: Part 5, Customize the Views](https://i3.ytimg.com/vi/RF6-2hern08/maxresdefault.jpg)](https://www.youtube.com/watch?v=RF6-2hern08)

[![Create a Kanban Task Management App with FilamentPHP: Part 6, Customize the Theme](https://i3.ytimg.com/vi/hyhmEIoWqTg/maxresdefault.jpg)](https://www.youtube.com/watch?v=hyhmEIoWqTg)

[![Create a Kanban Task Management App with FilamentPHP: Part 7, Custom Views per Kanban Board](https://i3.ytimg.com/vi/WddCaqyE0D0/maxresdefault.jpg)](https://www.youtube.com/watch?v=WddCaqyE0D0)

## Demos and Examples

- [Kanban Example](https://github.com/mokhosh/filament-kanban-example)

- [Kanban Todo](https://github.com/mokhosh/filament-kanban-todo)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## TODO

- [ ] remove deprecated recently updated trait
- [ ] stop passing record to view for recordClick
- [ ] use filament actions for edit modal

## Credits

- [Mo Khosh](https://github.com/mokhosh)
- [All Contributors](../../contributors)
- This original idea and structure of this package borrows heavily from [David Vincent](https://github.com/invaders-xx)'s [filament-kanban-board](https://github.com/invaders-xx/filament-kanban-board/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
