<?php

namespace Component;

/**
 * Render a template with arguments.
 * 
 * Access the arguments within the template through the variable `$comp`.
 * 
 * Example:
 * `
 * Component\Component::makeEcho('logo', [
 *  'size' => 'large',
 *  'img_id' => get_field('logo', 'options')
 * ]);
 * `
 * 
 * Within components/logo.php:
 * `
 * // default values
 * $comp = wp_parse_args($comp, [
 *  'size' => 'large',
 *  'img_id' => get_field('logo', 'options'),
 * ]);
 * 
 * extract($comp, EXTR_SKIP | EXTR_PREFIX_ALL, 'c');
 * ...
 * `
 */
class Component
{
    /**
     * Make a new component and returns it.
     * 
     * @param string $template_name The template name. Case sensitive.
     * @param array $args The arguments to pass into the template.
     * @param string $dir_path Override the components directory path.
     * @return Component The component instance.
     */
    static public function make($template_name, $args = null, $dir_path = null)
    {
        return new static($template_name, $args, $dir_path);
    }

    /**
     * Make a new component, render and return it.
     * 
     * @param string $template_name The template name. Case sensitive.
     * @param array $args The arguments to pass into the template.
     * @param string $dir_path Override the components directory path.
     * @return Component The component instance.
     */
    static public function makeEcho($template_name, $args = null, $dir_path = null)
    {
        return static::make($template_name, $args, $dir_path)->render();
    }

    /**
     * Make a new component, render and return the HTML.
     * 
     * @param string $template_name The template name. Case sensitive.
     * @param array $args The arguments to pass into the template.
     * @param string $dir_path Override the components directory path.
     * @return string HTML output.
     */
    static public function html($template_name, $args = null, $dir_path = null)
    {
        return static::make($template_name, $args, $dir_path)->output(false);
    }

    /**
     * @var string The directory to find the component.
     */
    protected $dir_path = 'components/';

    /**
     * @var string The template name.
     */
    protected $template_name;

    /**
     * @var string The arguments to pass to the template.
     */
    protected $args;

    /**
     * Construct a new component.
     * 
     * @param string $template_name The template name. Case sensitive.
     * @param array $args The arguments to pass into the template.
     * @param string $dir_path Override the components directory path.
     * @return void
     */
    public function __construct($template_name, $args = null, $dir_path = null)
    {
        $this->template_name = $template_name;
        $this->args = $args;

        if ( $dir_path ) {
            $this->dir_path = $dir_path;
        }
    }

    /**
     * Render the component's template.
     * 
     * @throws TemplateNotFoundException Thrown if the template could not be located.
     * 
     * @return Component The component instance.
     */
    public function render()
    {
        $template_name = $this->template_name;

        $path = trailingslashit($this->dir_path) . $template_name . '.php';
        $located = $this->locateTemplate( $path, $template_name );

        if ( $located ) {
            set_query_var('comp', $this->args);
            load_template($located, false);
        } else {
            throw new TemplateNotFoundException("Could not locate template for {$template_name}.");
        }

        return $this;
    }

    /**
     * Bind the component's rendering to a WordPress action.
     * 
     * The component will render when this action is called.
     * Any arguments within the action can be used as variable `action_args` within the template.
     * 
     * For example, to render a component when the WP footer is called:
     * `
     * \Component\Component::make('alert', [
     *       'title' => 'I\'m rendered right before the WP footer is rendered',
     *  ])->bind('wp_footer');
     * `
     * 
     * @param string $action The action name.
     * @param integer $priority The action priority.
     * @param integer $args_count The amount of arguments to expect from the action.
     * @return Component The component instance.
     */
    public function bind($action, $priority = 10, $args_count = 0)
    {
        $comp = $this;
        add_action($action, function () use($comp) {
            set_query_var('action_args', func_get_args());
            $comp->render();
        }, $priority, $args_count);

        return $this;
    }

    /**
     * Output the Component, conditionally either echo the HTML, or return it.
     * 
     * @param boolean $echo Echo or return the HTML.
     * @return string|void
     */
    public function output($echo)
    {
        if ( $echo ) {
            $this->render();
        } else {
            ob_start();
            $this->render();
            return ob_get_clean();
        }
    }

    /**
     * Locate the final template file.
     * 
     * Use the filter `component\locate_template' to include more directories,
     * such as if a plugin wants to introduce components.
     */
    protected function locateTemplate($path, $template_name)
    {
        /**
         * Locate the template file for a component.
         * 
         * @param string $path The path to the PHP file.
         * @param string $template_name The template being attempted to be retrieved.
         * @return mixed|void
         */
        return apply_filters('component\locate_template',
            locate_template($path, false, false),
            $template_name
        );
    }
}