# Component

Component is a library for WordPress to help make re-usuable templates.

Components can be passed arguments, and they can be easily bound to WordPress actions to be rendered. This makes components more reusable then the WordPress concept of template parts.

## Getting Started

This can be installed as a WordPress plugin, or the files within the `src` directory can be extracted into your project and used directly.

To install as a plugin:

```
cd /mywebsite/wp-content/plugins
git clone https://github.com/seankarol/Component.git
```

To integrate within an existing project:
* Copy the directory `src/Component` into your projects.
** Optionally copy `src/component.php` for the alias function `component`.
* Require the files below, or use an autoloader.

```
require_once __DIR__ . '/src/component.php';
require_once __DIR__ . '/src/Component/Component.php';
require_once __DIR__ . '/src/Component/TemplateNotFoundException.php';
```

## How To Use

Create your component files within your theme's `components` folder.
Component files can access arguments pass to them through the variable `comp`.

To render a component call `Component\Component::makeEcho('MyComponent', [ // arguments ])` or if you are using the alias function, call `component('MyComponent, [[ // arguments ]]);`

## Examples

See the `examples` directory on how to use.

If you're using this repository as a plugin, and would like to see the examples in action, uncomment this line within `index.php`:
`// require_once __DIR__ . '/examples/examples.php';`

## Built With

* [WordPress 5.2.2](https://wordpress.org/) - The web framework used
* [PHP 5.6.20](https://php.net)
* [MySQL 5.6.34](https://mysql.com)