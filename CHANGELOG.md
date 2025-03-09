# Changelog

All notable changes to `filament-kanban` will be documented in this file.

## v2.10.0 - 2025-03-09

### What's Changed

* Support Laravel v12
* Make date diffing absolute
* Bump dependabot/fetch-metadata from 1.6.0 to 2.0.0 by @dependabot in https://github.com/mokhosh/filament-kanban/pull/27
* Merge 2.x changes by @mokhosh in https://github.com/mokhosh/filament-kanban/pull/32
* Bump aglipanci/laravel-pint-action from 2.3.1 to 2.4 by @dependabot in https://github.com/mokhosh/filament-kanban/pull/34
* Bump dependabot/fetch-metadata from 2.0.0 to 2.1.0 by @dependabot in https://github.com/mokhosh/filament-kanban/pull/37
* Bump dependabot/fetch-metadata from 2.1.0 to 2.2.0 by @dependabot in https://github.com/mokhosh/filament-kanban/pull/48
* docs: Update README.md by @Dipesh79 in https://github.com/mokhosh/filament-kanban/pull/67
* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot in https://github.com/mokhosh/filament-kanban/pull/68
* Bump aglipanci/laravel-pint-action from 2.4 to 2.5 by @dependabot in https://github.com/mokhosh/filament-kanban/pull/69

### New Contributors

* @mokhosh made their first contribution in https://github.com/mokhosh/filament-kanban/pull/32
* @Dipesh79 made their first contribution in https://github.com/mokhosh/filament-kanban/pull/67

**Full Changelog**: https://github.com/mokhosh/filament-kanban/compare/v2.7.0...v2.10.0

## v2.9.0 - 2024-10-01

### What's Changed

* Allow custom stub file to be used for board. by @Cybrarist in https://github.com/mokhosh/filament-kanban/pull/58

### New Contributors

* @Cybrarist made their first contribution in https://github.com/mokhosh/filament-kanban/pull/58

**Full Changelog**: https://github.com/mokhosh/filament-kanban/compare/v2.8.0...v2.9.0

## v2.8.0 - 2024-04-08

### What's Changed

* Add edit modal slideover option by @ryanmortier in https://github.com/mokhosh/filament-kanban/pull/31

### New Contributors

* @ryanmortier made their first contribution in https://github.com/mokhosh/filament-kanban/pull/31

**Full Changelog**: https://github.com/mokhosh/filament-kanban/compare/v2.7.0...v2.8.0

## v2.7.0 - 2024-03-12

### What's Changed

* Add Laravell 11 support by @mokhosh and @gnovaro in https://github.com/mokhosh/filament-kanban/pull/24

### New Contributors

* @gnovaro made their first contribution in https://github.com/mokhosh/filament-kanban/pull/24

**Full Changelog**: https://github.com/mokhosh/filament-kanban/compare/v2.6.1...v2.7.0

## v2.6.1 - 2024-03-07

### What's Changed

* Fix the overflow hidden styling by @hussain4real in https://github.com/mokhosh/filament-kanban/pull/21

### New Contributors

* @hussain4real made their first contribution in https://github.com/mokhosh/filament-kanban/pull/21

**Full Changelog**: https://github.com/mokhosh/filament-kanban/compare/v2.6.0...v2.6.1

## v2.6.0 - 2024-03-07

### What's Changed

* Update KanbanBoard to not require a status property by @brenjt in https://github.com/mokhosh/filament-kanban/pull/20
* Add getEloquentQuery in queries by @aislandener in https://github.com/mokhosh/filament-kanban/pull/19

### New Contributors

* @brenjt made their first contribution in https://github.com/mokhosh/filament-kanban/pull/20
* @aislandener made their first contribution in https://github.com/mokhosh/filament-kanban/pull/19

**Full Changelog**: https://github.com/mokhosh/filament-kanban/compare/v2.5.0...v2.6.0

## v2.5.0 - 2024-03-06

Save relationships too when saving a record.

## v2.4.0 - 2024-02-28

- Allow int backed enums to be used as status enum
- Fixes #15
- Fixes #12

## v2.3.0 - 2024-02-25

- fixes https://github.com/mokhosh/filament-kanban/issues/14
- deprecate has recent update indication trait

## v2.2.0 - 2024-02-15

- fix animations not working
- fix cursor while grabbing

## fix the stub - 2024-02-09

the stub now reflects latest changes

## v2.1.0 - 2024-02-09

- $model and $statusEnum cannot be `null`
- add `HasRecentUpdateIndication` trait

## Version 2.x 🎉 - 2024-02-08

### Big update with breaking changes

- I've added tests. It was a challenge as there is very little resources on how to test FilamentPHP packages 😎
- We now pass the whole `Model` to the views. So, you don't need to define the data you need to use. Just use them.
- You now tell us which `Model` you're managing on this Kanban board, and we do most things for you. You don't have to override any methods. This includes loading records, updating them, sorting them, editing them, etc.
- We now include a text input for editing the title in the edit form by default.

Imagine if you had this:

```php
<?php

namespace App\Filament\Pages;

use App\Enums\UserStatus;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class UserDashboard extends KanbanBoard
{
    protected function statuses(): Collection
    {
        return UserStatus::statuses();
    }

    protected function records(): Collection
    {
        return User::ordered()->get();
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        User::find($recordId)->update(['status' => $status]);

        User::setNewOrder($toOrderedIds);
    }

    public function onSortChanged(int $recordId, string $status, array $orderedIds): void
    {
        User::find($recordId)->touch('updated_at');
        
        User::setNewOrder($orderedIds);
    }

    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
            TextInput::make('title'),
        ];
    }

    protected function getEditModalRecordData($recordId, $data): array
    {
        return User::find($recordId)->toArray();
    }

    protected function editRecord($recordId, array $data, array $state): void
    {
        User::find($recordId)->update([
            'title' => $data['title']
        ]);
    }

    protected function additionalRecordData(Model $record): Collection
    {
        return collect([
            'deficiencies' => $record->deficiencies,
        ]);
    }
}













```
Now you can have just this:

```php
use App\Enums\UserStatus;
use App\Models\User;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class UserDashboard extends KanbanBoard
{
    protected static ?string $model = User::class;
    protected static ?string $statusEnum = UserStatus::class;
}













```
## Version 2.0.0 🎉 - 2024-02-07

### Big update with breaking changes

- I've added tests. It was a challenge as there is very little resources on how to test FilamentPHP packages 😎
- We now pass the whole `Model` to the views. So, you don't need to define the data you need to use. Just use them.
- You now tell us which `Model` you're managing on this Kanban board, and we do most things for you. You don't have to override any methods. This includes loading records, updating them, sorting them, editing them, etc.
- We now include a text input for editing the title in the edit form by default.

Imagine if you had this:

```php
<?php

namespace App\Filament\Pages;

use App\Enums\UserStatus;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class UserDashboard extends KanbanBoard
{
    protected function statuses(): Collection
    {
        return UserStatus::statuses();
    }

    protected function records(): Collection
    {
        return User::ordered()->get();
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        User::find($recordId)->update(['status' => $status]);

        User::setNewOrder($toOrderedIds);
    }

    public function onSortChanged(int $recordId, string $status, array $orderedIds): void
    {
        User::find($recordId)->touch('updated_at');
        
        User::setNewOrder($orderedIds);
    }

    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
            TextInput::make('title'),
        ];
    }

    protected function getEditModalRecordData($recordId, $data): array
    {
        return User::find($recordId)->toArray();
    }

    protected function editRecord($recordId, array $data, array $state): void
    {
        User::find($recordId)->update([
            'title' => $data['title']
        ]);
    }

    protected function additionalRecordData(Model $record): Collection
    {
        return collect([
            'deficiencies' => $record->deficiencies,
        ]);
    }
}














```
Now you can have just this:

```php
use App\Enums\UserStatus;
use App\Models\User;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class UserDashboard extends KanbanBoard
{
    protected static ?string $model = User::class;
    protected static ?string $statusEnum = UserStatus::class;
}














```
## v1.11.0 - 2024-01-30

now you can customize views per kanban board

## dark mode + other goodies - 2024-01-20

- dark mode
- modernize the looks
- embellishments for status titles
- bottom padding for scrollbar
- make status columns full hight for easier drag and drop
- add visual feedback to records that "just updated"

## hacky fix to the actual issue - 2024-01-19

the previous attempt at fixing the issue with form that have a rich editor in them wasn't addressing the actual issue.

the issue is that when you have a working rich editor in the form, sometimes the form schema is created before the click record action is handled, which makes the form use the obsolete `$editModalRecordId`.

the form didn't have an issue before adding `mount` with `$form->fill()` only because the rich editor was broken.
and when you fix it by adding the `mount` method, it starts messing up the flow. if you don't set the `$editModalRecordId` to null you might feel like you're avoiding some issues, but the form is using old `$editModalRecordId` for building schema.

here I've manually triggered a schema creation inside the click handler to fix the issue, but i don't like it.

would appreciate if you have better solutions.

## fix edit modal not receving record id after updating another model if a richtext is present - 2024-01-19

this was a weird one.

if you have a `RichText` in your form schema, and you update one of the records, the next time you click on a card the form won't receive the `recordId` in `getEditModalFormSchema`.

this fixes it.

hopefully not introducing any regression. i set the record id to `null` as a safety measure anyway.

## fix rich editor not being filled in modal - 2024-01-19

fix `Livewire property ['editModalFormState...'] cannot be found on component: ['...']`

## v1.8.0 - 2023-12-29

Two fixes by https://github.com/Log1x
🩹 Fix nullable state property
🩹 Fix sorting when using SPA mode

## v1.7.0 - 2023-12-02

only describe additional data if you dont want to override the defaults

## v1.6.0 - 2023-12-02

use enum value as status if the property on model has been cast to an enum

## v1.5.0 - 2023-12-02

use enum value for id to allow backed enum casts on models

## v1.4.0 - 2023-11-30

make assets publishable

## v1.3.0 - 2023-11-30

update stubs

## v1.2.0 - 2023-11-30

add a way to disable edit modal

## v1.1.0 - 2023-11-30

add sorting and ordering

## 1.0.0 - 202X-XX-XX

- initial release
