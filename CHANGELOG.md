# Changelog

All notable changes to `filament-kanban` will be documented in this file.

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
