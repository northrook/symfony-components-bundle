# Northrook Components

A collection of reusable components for Symfony, using Latte.

## Installation

> [!NOTE]
> This bundle is intended to be used by the [Northrook Symfony Core Bundle][scb].
>
> Stand-alone usage is **_not_** supported at this time.

Install the bundle stand-alone with Composer:

```shell
composer require northrook/symfony-components-bundle
```

## Usage

The bundle parses each `.latte` template file when rendering, and replaces components with
parsed HTML and PHP code, ready to be rendered by the Symfony framework.

Example for a `field` component:

```html
// in template.latte
<field:email name="email" label="Email" required autofocus autocomplete="username"/>

// output in cached template
<field id="email-input-component" class="email field">
    <div class="label">
        <label for="email">
            Email
        </label>
    </div>
    <div class="input">
        <input id="email" type="email" name="email" autocomplete="username">
    </div>
</field>
```

## Contributing

This bundle is not currently accepting contributions, and is subject to change.

Feel free to reach out to us if you have any questions or suggestions.


[scb]: https://github.com/northrook/symfony-core-bundle