<?php
/*
Plugin Name: Component
Description: Make reusuable template parts.
Version: 1.0.0
Author: Sean Karol
Author URI: https://www.seankarol.com
Copyright: Sean Karol
Text Domain: component
License: GPL2

Component is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Component is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Component. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
*/

// These files can be extracted out of the plugin
// within your plugin / theme and used as-is.
require_once __DIR__ . '/src/component.php';
require_once __DIR__ . '/src/Component/Component.php';
require_once __DIR__ . '/src/Component/TemplateNotFoundException.php';

// Uncomment if you'd like to see the examples.
require_once __DIR__ . '/src/examples/examples.php';