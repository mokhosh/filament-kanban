# Changelog

All notable changes to `filament-kanban` will be documented in this file.

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
