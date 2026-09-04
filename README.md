<img src="https://banners.beyondco.de/Filament%20Banhammer.png?theme=light&packageManager=composer+require&packageName=gerenuk%2Ffilament-banhammer&pattern=brickWall&style=style_1&description=Ban+resources+in+your+Filament+project&md=1&showWatermark=0&fontSize=100px&images=ban" alt="Project banner">

# Filament Banhammer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gerenuk/filament-banhammer.svg?style=flat-square)](https://packagist.org/packages/gerenuk/filament-banhammer)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/gerenuk-ltd/filament-banhammer/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/gerenuk-ltd/filament-banhammer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/gerenuk-ltd/filament-banhammer/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/gerenuk-ltd/filament-banhammer/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/gerenuk/filament-banhammer.svg?style=flat-square)](https://packagist.org/packages/gerenuk/filament-banhammer)
[![Licence](https://img.shields.io/github/license/Gerenuk-LTD/filament-banhammer?color=blue&label=license&style=flat-square)](https://github.com/Gerenuk-LTD/filament-banhammer/blob/main/LICENSE.md)

This package uses [mchev/banhammer](https://github.com/mchev/banhammer) to add model banning functionality to filament.

## Table of Contents
1. [Introduction](#filament-banhammer)
2. [Version Compatibility](#version-compatibility)
3. [Installation](#installation)
4. [Usage](#usage)
    - [Registering the Plugin](#usage)
    - [Ban](#ban)
    - [Unban](#unban)
    - [Ban Bulk](#ban-bulk)
    - [Unban Bulk](#unban-bulk)
    - [Authorization](#authorization)
    - [Trashed Bans](#trashed-bans)
    - [IP Blocking](#ip-blocking)
    - [Country Blocking](#country-blocking)
5. [Testing](#testing)
6. [Screenshots](#screenshots)
    - [Resource](#resource)
    - [Ban Action](#ban-action)
    - [Ban Bulk Action](#ban-bulk-action)
    - [Ban Modal](#ban-modal)
    - [Unban Action](#unban)
    - [Unban Bulk Action](#unban-bulk)
    - [Unban Modal](#unban-modal)
7. [Changelog](#changelog)
8. [Contributing](#contributing)
9. [Security Vulnerabilities](#security-vulnerabilities)
10. [Credits](#credits)
11. [License](#license)

## Version Compatibility

| Plugin | Filament | Laravel     | PHP           |
| ------ | -------- | ----------- | ------------- |
| 2.x    | 5.x      | 11.28\|12\|13 | 8.2\|8.3\|8.4 |
| 1.x    | 3.x      | 10.x        | 8.x           |
| 1.x    | 3.x      | 11.x        | 8.2\|8.3      |

## Installation

This package depends on [mchev/banhammer](https://github.com/mchev/banhammer) please follow the install guide there first.

You can install the package via composer:

```bash
composer require gerenuk/filament-banhammer
```

> [!IMPORTANT]
> Ensure you have already installed [mchev/banhammer](https://github.com/mchev/banhammer) before doing this.

This package's own migration (for the [Country Blocking](#country-blocking) feature) is picked up automatically by `php artisan migrate` — no `vendor:publish` needed, unless you'd rather have the migration file alongside your own, in which case publish it with:

```bash
php artisan vendor:publish --tag="filament-banhammer-migrations"
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-banhammer-config"
```

This is the contents of the published config file:

<details>
  <summary>Click to expand!</summary>

    return [
    
        /*
         * The name of the resource which the plugin should use.
         */
        'resource' => \Gerenuk\FilamentBanhammer\Resources\BanhammerResource::class,
    
        /*
         * Whether an export action should be included on the resource.
         */
        'show_export' => true,
    
        /*
         * The exporter used by the export bulk action.
         */
        'exporter' => \Gerenuk\FilamentBanhammer\Exports\BanExporter::class,
    
        /*
         * Options for soft-deleted bans.
         */
        'trashed' => [
            'enabled' => true,
            'force_delete' => false,
        ],
    
        /*
         * Options for banning raw IP addresses.
         */
        'ip_blocking' => [
            'enabled' => true,
        ],
    
        /*
         * Options for managing mchev/banhammer's blocked countries list.
         */
        'country_blocking' => [
            'enabled' => false,
            'resource' => \Gerenuk\FilamentBanhammer\Resources\BlockedCountryResource::class,
        ],
    
        /*
         * The policy ability checked before each action runs.
         */
        'authorization' => [
            'ban' => 'ban',
            'edit_ban' => 'editBan',
            'unban' => 'unban',
            'ban_ip' => 'banIp',
        ],
    
        /*
         * Options for the actions.
         */
        'actions' => [
    
            /*
             * Options for the ban action.
             */
            'ban' => [
    
                /*
                 * The title of the ban action.
                 */
                'label' => 'ban',
    
                /*
                 * The colour of the ban action.
                 */
                'colour' => 'warning',
    
                /*
                 * The symbol of the ban action.
                 */
                'icon' => 'heroicon-o-no-symbol',
    
                /*
                 * Whether confirming is required when using the ban action.
                 */
                'require_confirmation' => true,
    
                /*
                 * Notification options for the ban action.
                 */
                'notifications' => [
    
                    /*
                     * Whether a notification should be shown for the ban action.
                     */
                    'show' => true,
    
                    /*
                     * Success options for the ban action notifications.
                     */
                    'success' => [
    
                        /*
                        * The title of the success notification for the ban action.
                        */
                        'title' => 'Banned',
    
                    ],
    
                    /*
                     * Error options for the ban action notifications.
                     */
                    'error' => [
    
                        /*
                        * The title of the error notification for the ban action.
                        */
                        'title' => 'Failed',
    
                    ],
    
                ],
    
            ],
    
            /*
             * Options for the edit ban action.
             */
            'edit_ban' => [
    
                /*
                 * The title of the edit ban action.
                 */
                'label' => 'edit ban',
    
                /*
                 * The colour of the edit ban action.
                 */
                'colour' => 'warning',
    
                /*
                 * The symbol of the edit ban action.
                 */
                'icon' => 'heroicon-o-pencil-square',
    
                /*
                 * Whether confirming is required when using the edit ban action.
                 */
                'require_confirmation' => true,
    
                /*
                 * Notification options for the edit ban action.
                 */
                'notifications' => [
    
                    /*
                     * Whether a notification should be shown for the edit ban action.
                     */
                    'show' => true,
    
                    /*
                     * Success options for the edit ban action notifications.
                     */
                    'success' => [
    
                        /*
                        * The title of the success notification for the edit ban action.
                        */
                        'title' => 'Saved',
    
                    ],
    
                    /*
                     * Error options for the edit ban action notifications.
                     */
                    'error' => [
    
                        /*
                        * The title of the error notification for the edit ban action.
                        */
                        'title' => 'Failed',
    
                    ],
    
                ],
    
            ],
    
            /*
             * Options for the unban action.
             */
            'unban' => [
    
                /*
                 * The title of the unban action.
                 */
                'label' => 'unban',
    
                /*
                 * The colour of the unban action.
                 */
                'colour' => 'warning',
    
                /*
                 * The symbol of the unban action.
                 */
                'icon' => 'heroicon-o-no-symbol',
    
                /*
                 * Whether confirming is required when using the unban action.
                 */
                'require_confirmation' => true,
    
                /*
                 * Notification options for the unban action.
                 */
                'notifications' => [
    
                    /*
                     * Whether a notification should be shown for the unban action.
                     */
                    'show' => true,
    
                    /*
                     * Success options for the unban action notifications.
                     */
                    'success' => [
    
                        /*
                        * The title of the success notification for the unban action.
                        */
                        'title' => 'Unbanned',
    
                    ],
    
                    /*
                     * Error options for the unban action notifications.
                     */
                    'error' => [
    
                        /*
                        * The title of the error notification for the unban action.
                        */
                        'title' => 'Failed',
    
                    ],
    
                ],
    
            ],
    
            /*
             * Options for the ban bulk action.
             */
            'ban_bulk' => [
    
                /*
                 * The title of the ban bulk action.
                 */
                'label' => 'ban',
    
                /*
                 * The colour of the ban bulk action.
                 */
                'colour' => 'warning',
    
                /*
                 * The symbol of the ban bulk action.
                 */
                'icon' => 'heroicon-o-no-symbol',
    
                /*
                 * Whether confirming is required when using the ban bulk action.
                 */
                'require_confirmation' => true,
    
                /*
                 * Notification options for the ban bulk action.
                 */
                'notifications' => [
    
                    /*
                     * Whether a notification should be shown for the ban bulk action.
                     */
                    'show' => true,
    
                    /*
                     * Success options for the ban bulk action notifications.
                     */
                    'success' => [
    
                        /*
                        * The title of the success notification for the ban bulk action.
                        */
                        'title' => 'Banned',
    
                    ],
    
                    /*
                     * Error options for the ban bulk action notifications.
                     */
                    'error' => [
    
                        /*
                        * The title of the error notification for the ban bulk action.
                        */
                        'title' => 'Failures',
    
                    ],
    
                ],
    
            ],
    
            /*
             * Options for the edit ban bulk action.
             */
            'edit_ban_bulk' => [
    
                /*
                 * The title of the edit ban bulk action.
                 */
                'label' => 'edit ban',
    
                /*
                 * The colour of the edit ban bulk action.
                 */
                'colour' => 'warning',
    
                /*
                 * The symbol of the edit ban bulk action.
                 */
                'icon' => 'heroicon-o-pencil-square',
    
                /*
                 * Whether confirming is required when using the edit ban bulk action.
                 */
                'require_confirmation' => true,
    
                /*
                 * Notification options for the edit ban bulk action.
                 */
                'notifications' => [
    
                    /*
                     * Whether a notification should be shown for the edit ban bulk action.
                     */
                    'show' => true,
    
                    /*
                     * Success options for the edit ban bulk action notifications.
                     */
                    'success' => [
    
                        /*
                        * The title of the success notification for the edit ban bulk action.
                        */
                        'title' => 'Saved',
    
                    ],
    
                    /*
                     * Error options for the edit ban bulk action notifications.
                     */
                    'error' => [
    
                        /*
                        * The title of the error notification for the edit ban bulk action.
                        */
                        'title' => 'Failures',
    
                    ],
    
                ],
    
            ],
    
            /*
             * Options for the unban bulk action.
             */
            'unban_bulk' => [
    
                /*
                 * The title of the unban bulk action.
                 */
                'label' => 'unban',
    
                /*
                 * The colour of the unban bulk action.
                 */
                'colour' => 'warning',
    
                /*
                 * The symbol of the unban bulk action.
                 */
                'icon' => 'heroicon-o-no-symbol',
    
                /*
                 * Whether confirming is required when using the unban bulk action.
                 */
                'require_confirmation' => true,
    
                /*
                 * Notification options for the unban bulk action.
                 */
                'notifications' => [
    
                    /*
                     * Whether a notification should be shown for the unban bulk action.
                     */
                    'show' => true,
    
                    /*
                     * Success options for the unban bulk action notifications.
                     */
                    'success' => [
    
                        /*
                        * The title of the success notification for the unban bulk action.
                        */
                        'title' => 'Unbanned',
    
                    ],
    
                    /*
                     * Error options for the unban bulk action notifications.
                     */
                    'error' => [
    
                        /*
                        * The title of the error notification for the unban bulk action.
                        */
                        'title' => 'Failures',
    
                    ],
    
                ],
    
            ],
    
        ],
    
    ];
</details>

## Usage

You first need to register the plugin with Filament. This can be done inside of your `PanelProvider`, e.g. `AdminPanelProvider`.

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Gerenuk\FilamentBanhammer\FilamentBanhammerPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugin(FilamentBanhammerPlugin::make());
    }
}
```
For each model you have added the `use Banhammer` trait to, you will also need to add the following method:

```php
public function getFilamentBanhammerTitleAttribute()
{
    return $this->name;
}
```
> [!IMPORTANT]
> This specifies which property to be displayed in the bans resource.

### Ban

To be able to ban a resource simply add the `Ban` action:

```php
use Filament\Tables\Table;
use Gerenuk\FilamentBanhammer\Resources\Actions\BanAction;

public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ...
            ])
            ->recordActions([
                BanAction::make(),
            ]);
    }
```

### Unban

To be able to unban a resource simply add the `Unban` action:

```php
use Filament\Tables\Table;
use Gerenuk\FilamentBanhammer\Resources\Actions\UnbanAction;

public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ...
            ])
            ->recordActions([
                UnbanAction::make(),
            ]);
    }
```
> A ban resource is included by default if you would prefer to use that instead. `UnbanAction` works whether it's placed on your own bannable resource's table (as above) or on the bundled ban resource's table, where the record is a ban itself rather than the bannable model.

### Ban Bulk

To be able to bulk ban a resource simply add the `BanBulk` action:

```php
use Filament\Tables\Table;
use Gerenuk\FilamentBanhammer\Resources\Actions\BanBulkAction;

public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ...
            ])
            ->toolbarActions([
                BanBulkAction::make(),
            ]);
    }
```

### Unban Bulk

To be able to bulk unban a resource simply add the `UnbanBulk` action:

```php
use Filament\Tables\Table;
use Gerenuk\FilamentBanhammer\Resources\Actions\UnbanBulkAction;

public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ...
            ])
            ->toolbarActions([
                UnbanBulkAction::make(),
            ]);
    }
```
> A ban resource is included by default if you would prefer to use that instead.

### Authorization

`BanAction`, `BanBulkAction`, `UnbanAction`, `UnbanBulkAction`, `EditBanAction`, `EditBanBulkAction` and `BanIpAction` each check a Laravel policy ability against the record they're acting on, named in the `authorization` config key (`ban`, `unban`, `editBan` and `banIp` by default). If the record's model has no policy, or the policy has no method by that name, the action is allowed — so nothing changes until you opt in by adding the method:

```php
class UserPolicy
{
    public function ban(?User $user, User $target): bool
    {
        return $user?->isAdmin() ?? false;
    }
}
```

Restoring and force-deleting bans (see [Trashed Bans](#trashed-bans)) aren't in the `authorization` config — they use Filament's own `restore`/`forceDelete` resource policy conventions instead.

### Trashed Bans

Bans are soft-deleted (via `mchev/banhammer`'s `Ban` model), so the bundled resource ships a "trashed" filter and restore actions by default. Force-deleting a ban permanently is opt-in:

```php
'trashed' => [
    'enabled' => true,
    'force_delete' => false,
],
```

### IP Blocking

The bundled resource includes a "Ban IP" header action that creates an IP-only ban with no bannable model attached, using `mchev/banhammer`'s IP bans. Existing bans, including IP-only ones, can be edited (to correct the IP) and unbanned like any other row. Disable it with:

```php
'ip_blocking' => [
    'enabled' => false,
],
```

### Country Blocking

`mchev/banhammer` can block requests by country, but manages the blocked list through its own `blocked_countries` config value. Enabling `country_blocking` adds a bundled resource for managing that list from the database instead, and merges it into `ban.blocked_countries` on every request:

```php
'country_blocking' => [
    'enabled' => true,
],
```

This package's migration needs to have run first — see [Installation](#installation). Note this only manages the *list*; you still need `mchev/banhammer`'s own `BANHAMMER_BLOCK_BY_COUNTRY` env variable (or `block_by_country` config value) set to actually enable the country-blocking middleware.

## Testing

```bash
composer test
```

## Screenshots

### Resource

![Ban Resource](https://raw.githubusercontent.com/Gerenuk-LTD/filament-banhammer/main/screenshots/ban-resource.png)

### Ban Action

![Ban Action](https://raw.githubusercontent.com/Gerenuk-LTD/filament-banhammer/main/screenshots/ban-action.png)

### Ban Bulk Action

![Ban Bulk Action](https://raw.githubusercontent.com/Gerenuk-LTD/filament-banhammer/main/screenshots/ban-bulk-action.png)

### Ban Modal

![Ban Modal](https://raw.githubusercontent.com/Gerenuk-LTD/filament-banhammer/main/screenshots/ban-modal.png)

### Unban Action

![Unban Action](https://raw.githubusercontent.com/Gerenuk-LTD/filament-banhammer/main/screenshots/unban-action.png)

### Unban Bulk Action

![Unban Bulk Action](https://raw.githubusercontent.com/Gerenuk-LTD/filament-banhammer/main/screenshots/unban-bulk-action.png)

### Unban Modal

![Unban Modal](https://raw.githubusercontent.com/Gerenuk-LTD/filament-banhammer/main/screenshots/unban-modal.png)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- Based on [laravel-banhammer](https://github.com/mchev/banhammer) from [mchev](https://github.com/mchev)
- [Kieran Proctor](https://github.com/KieranLProctor)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
