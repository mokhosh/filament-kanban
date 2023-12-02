# Add kanban boards to your Filament pages

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mokhosh/filament-kanban.svg?style=flat-square)](https://packagist.org/packages/mokhosh/filament-kanban)
[![Total Downloads](https://img.shields.io/packagist/dt/mokhosh/filament-kanban.svg?style=flat-square)](https://packagist.org/packages/mokhosh/filament-kanban)


Easily add kanban board pages to your Filament panels.

## Installation

You can install the package via composer:

```bash
composer require mokhosh/filament-kanban
```

Publish the assets so the styles are correct:

```bash
# Publish all filament assets
php artisan filament:assets
# OR
php artisan filament-kanban:install
# OR
php artisan vendor:publish --tag=filament-kanban-assets
```

## Usage

You can create a new kanban board using this artisan command:

```php
php artisan make:kanban UsersKanbanBoard
```

This will create a good starting point for your kanban board. From there you can start customizing the kanban board to your liking.

There are four methods you should override to get the basic functionality.

1. `statuses` which defines your statuses or lists.
2. `records` which provides all the records or items that you want to see on your board.
3. `onStatusChanged` which defines what happens when a record is moved between statuses.
4. `onSortChanged` which defines what happens when a record is moved inside the same status.

```php
protected function statuses(): Collection
{
    // return StatusEnum::statuses();
}

protected function records(): Collection
{
    // return Model::ordered()->get();
}

public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
{
    // Model::find($recordId)->update(['status' => $status]);
    // Model::setNewOrder($toOrderedIds);
}

public function onSortChanged(int $recordId, string $status, array $orderedIds): void
{
    // Model::setNewOrder($orderedIds);
}
```

## Recommendations

I recommend you create a string backed Enum for your statuses, which you can use as a cast on your model as well.
You can use the trait `IsKanbanStatus` so you can easily transform your enum cases for the kanban board using the `statuses` method on your enum.

I recommend you cast your `status` attribute to the enum that you have created.

I also recommend using the [Spatie Eloquent Sortable](https://github.com/spatie/eloquent-sortable) package on your model to get the `ordered` and `setNewOrder` methods for free.

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

I recommend delete the files that you don't intend to customize and keep the ones you want to change.
This way you will get any possible future updates for the original views.

If you need to add more data to the `record` variables that are passed to the views, you can override this method:

```php
protected function additionalRecordData(Model $record): Collection
{
    return collect([]);
}
```

These items will be merged with `id`, `title` and `status` and avialable in the views.

If you need to override how the id, title and status are retrieved from the record, you can override this method:

```php
protected function transformRecords(Model $record): Collection
{
    return collect([
        'id' => $record->id,
        'title' => $record->{static::$recordTitleAttribute},
        'status' => $record->{static::$recordStatusAttribute},
        // add anything else you might need in your views
    ]);
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

### Customizing the form data

By default, the same data that is used on the boards in passed to the form to avoid unnecessary database queries.
If you need more data in your form you can customize the form data by overriding this method:

```php
protected function getEditModalRecordData($recordId, $data): array
{
    return Model::find($recordId)->toArray();
}
```

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

You can customize modal's title, size and the labels for save and cancel buttons:

```php
protected string $editModalTitle = 'Edit Record';

protected string $editModalWidth = '2xl';

protected string $editModalSaveButtonLabel = 'Save';

protected string $editModalCancelButtonLabel = 'Cancel';
```

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

- [ ] update readme
- [ ] update changelog
- [ ] use filament actions for edit modal
- [ ] write tests and check wth the testing folder does

## Credits

- [Mo Khosh](https://github.com/mokhosh)
- [All Contributors](../../contributors)
- This original idea and structure of this package borrows heavily from [David Vincent](https://github.com/invaders-xx)'s [filament-kanban-board](https://github.com/invaders-xx/filament-kanban-board/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
