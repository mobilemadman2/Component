<pre style="background-color:#eee; margin: 1rem 0;">
    Arguments.php:
    Hello, this component accepts arguments.

    This means I can be re-used in multiple places.

    These arguments can be accessed through the variable $comp.

    Title: <?php echo $comp['title']; ?>

    Description: <?php echo $comp['description']; ?>

    Sum: <?php echo array_sum($comp['sum']); ?>
</pre>