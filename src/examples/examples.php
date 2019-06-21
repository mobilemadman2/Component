<?php
/**
 * Examples on using Component.
 */

/**
 * Components by default will only look in the parent/child theme's `component` folder.
 * 
 * We will add a filter to also look into this plugins `src/examples/components` folder.
 */
function component_example_locate_template($path, $template_name) {
    if (! $path ) {
        $file = __DIR__ . DIRECTORY_SEPARATOR . "components/$template_name.php";
        return file_exists($file) ? $file : $path;
    }

    return $path;
}
add_filter('component\locate_template', 'component_example_locate_template', 10, 2);

/**
 * Render a few example components after the footer.
 * 
 * In most cases these could be called within your theme's templates.
 */
function component_example_footer() {
    // Just a simple component with a bit of text.
    // src/examples/components/Simple.php
    component('Simple'); 

    // A component that accepts arguments.
    // src/examples/components/Arguments.php
    component('Arguments', [
        'title' => 'Cosmonaut',
        'description' => 'Lorem Ipsum',
        'sum' => [
            10,
            32,
            95
        ]
    ]);

    ?>
    <p>Multiple Card components to demonstrate reusability:</p>
    <div style="display: flex; flex-flow: row wrap; justify-content: flex-start; align-items: flex-start; max-width: 960px; margin: 0 auto;">
        <?php
        component('Card', [
            'title' => 'Google',
            'body' => 'Lorem Ipsum',
        ]);
        
        component('Card', [
            'title' => 'Apple',
            'body' => 'Lorem Ipsum',
        ]); 

        component('Card', [
            'title' => 'Facebook',
            'body' => 'Lorem Ipsum',
        ]);
        ?>
    </div>
    <?php
}
add_action('wp_footer', 'component_example_footer');

/**
 * Components can be bound to a WordPress action to be rendered.
 */
function component_example_bind() {
    // This component will be rendered when the action `wp_footer` is called.
    (new Component\Component('Bind'))->bind('wp_footer');
}
add_action('init', 'component_example_bind');