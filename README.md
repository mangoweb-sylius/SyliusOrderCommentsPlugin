<p align="center">
    <a href="https://www.mangoweb.cz/en/" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/38423357?s=200&v=4"/>
    </a>
</p>
<h1 align="center">
Order Comments Plugin
<br />
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-order-comments-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/mangoweb-sylius/sylius-order-comments-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-order-comments-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/mangoweb-sylius/sylius-order-comments-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/mangoweb-sylius/SyliusOrderCommentsPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/mangoweb-sylius/SyliusOrderCommentsPlugin/master.svg" />
    </a>
</h1>

## Features

* Create notes on order details
* Send personalized email to the addressee of the order

<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusOrderCommentsPlugin/master/doc/CreateEmailsAndNotes.png"/>
</p>

## Installation

1. Run `$ composer require mangoweb-sylius/sylius-order-comments-plugin`.
2. Register `\MangoSylius\OrderCommentsPlugin\MangoSyliusOrderCommentsPlugin` in your Kernel.
4. Import `@MangoSyliusOrderCommentsPlugin/Resources/config/routing.yml` in the routing.yml.

## Usage

## Development

### Usage

- Create symlink from .env.dist to .env or create your own .env file
- Develop your plugin in `/src`
- See `bin/` for useful commands

### Testing

After your changes you must ensure that the tests are still passing.

```bash
$ composer install
$ bin/console doctrine:schema:create -e test
$ bin/behat.sh
$ bin/phpstan.sh
$ bin/ecs.sh
```

License
-------
This library is under the MIT license.

Credits
-------
Developed by [manGoweb](https://www.mangoweb.eu/).