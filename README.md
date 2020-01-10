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

2. Add plugin classes to your `config/bundles.php`:
 
   ```php
   return [
      ...
      MangoSylius\OrderCommentsPlugin\MangoSyliusOrderCommentsPlugin::class => ['all' => true],
   ];
   ```
  
3. Add resource to `config/packages/_sylius.yaml`

    ```yaml
    imports:
         ...
         - { resource: "@MangoSyliusOrderCommentsPlugin/Resources/config/mailer.yml" }
    ```
   
4. Add routing to `config/_routes.yaml`

    ```yaml
    mango_sylius_order_comments_plugin:
      resource: "@MangoSyliusOrderCommentsPlugin/Resources/config/routing.yml"
      prefix: /admin
    ```
5. Override the template in SyliusAdminBundle:Order:Show:_notes.html.twig

   ```twig
   {% if order.notes is not null %}
       <h4 class="ui top attached styled header">
           {{ 'sylius.ui.notes'|trans }}
       </h4>
       <div class="ui attached segment" id="sylius-order-notes">
           {{ order.notes }}
       </div>
   {% endif %}
   
   <div class="ui segment">
       {{ render(controller(
           'MangoSylius\\OrderCommentsPlugin\\Controller\\OrderMessageController::contactAction', {id: order.id}
       )) }}
   </div>
   
   {{ render(controller(
       'MangoSylius\\OrderCommentsPlugin\\Controller\\OrderMessageController::showAction', {id: order.id}
   )) }}
    ```

6. Create and run doctrine database migrations.

For the guide how to use your own entity see [Sylius docs - Customizing Models](https://docs.sylius.com/en/1.6/customization/model.html)

## Usage

* Log into admin panel
* Click on `Orders` in the `Sales` section in main menu
* Select the order you want to check
* Write your note or email content into the `OrderMessage` panel
* Check the `Send to customer` option if you want to send an email to the customer
* Click `Send` button below

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