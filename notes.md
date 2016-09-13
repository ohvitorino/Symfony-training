# Development notes

Use `dump` function to dump content of variables and such. This will display the content within the development toolbar.

```php
public function indexAction(Request $request) 
{
    dump($request);
    
    return new Response("Hello");
}
```

## Services

Use the `shared: false` when we want services to be instantiated every time we call `$this->get('service_name')`

## Twig

`strict_variables` is set to true in `DEV` mode and false on `PROD` mode.

Use [TwigFiddle](http://twigfiddle.com) to test templating code, just like jsFiddle.

There's a Twig extension compiled from C that enables a performance boost up to 15%.

Short syntax for blocks `{% block title 'Hangman Game' %}`.

Embed twig tag (`embed`) it mixes include and extend.

# Deployment notes

- [Capistrano](http://capistranorb.cmo) (Ruby)

- [Fabric](http://www.fabfile.org) (Python)

- Any env variable starting with SYMFONY__ can be inject into symfony as used as a configuration parameter. This is even
recommended for storing the passwords.

# Questions

How to test database inserts