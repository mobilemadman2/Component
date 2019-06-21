<?php

if ( ! function_exists('component') ) {
    /**
     * Alias function to calling `Component\Component::makeEcho(...)`
     */
    function component() {
        if ( class_exists('Component\Component') ) {
            return Component\Component::makeEcho(...func_get_args());
        }
    }
}