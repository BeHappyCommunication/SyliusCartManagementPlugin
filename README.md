# sylius-cart-management
A Plugin to save and fetch carts in Sylius.

# Installation-procedure
```bash
$ composer require behappy/cart-management-plugin
```

## Enable the plugin
Since this plugin has dependencies, you must also enable those.

```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = array(
		// ...
        new \BeHappy\SyliusCartManagementPlugin\BeHappySyliusCartManagementPlugin(),
    );
    // ...
}
```

```yaml
#in app/config/config.yml
imports:
    ...
    - { resource: "@BeHappySyliusCartManagementPlugin/Resources/config/config.yml" }
    ...
```

```yaml
# in routing.yml
...
behappy_cart_management_plugin.shop:
    resource: '@BeHappySyliusCartManagementPlugin/Resources/config/routing.yaml'
    prefix: /{_locale}
...
```

## Generate database
Simply launch

```bash
php bin/console doctrine:schema:update --dump-sql --force
``` 

# That's it !
You now have access to multiple new routes to manage your customer's carts, such as 

```
behappy_cart_management_plugin.cart.save
behappy_cart_management_plugin.cart.load
behappy_cart_management_plugin.account.saved_cart_list
behappy_cart_management_plugin.account.saved_cart_show
behappy_cart_management_plugin.account.saved_cart_delete
```

At the moment, only front office is supported by this plugin, but back will come soon enough.

# Feel free to contribute
You can also ask your questions at the mail address in the composer.json mentioning this package.

# Other
You can also check our other packages (including Sylius plugins) at https://github.com/BeHappyCommunication
