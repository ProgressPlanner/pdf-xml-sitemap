<?php
/**
 * PHPUnit bootstrap file.
 *
 * @package JoostBlog\Tests
 */

namespace JoostBlog\Tests;

use Yoast\WPTestUtils\WPIntegration;

require_once \dirname( __DIR__ ) . '/vendor/yoast/wp-test-utils/src/WPIntegration/bootstrap-functions.php';

// Give access to tests_add_filter() function.
require_once \rtrim( WPIntegration\get_path_to_wp_test_dir(), '/' ) . '/includes/functions.php';

/**
 * Manually load the plugin being tested, plus stand-ins for the Yoast SEO classes it uses.
 *
 * @return void
 */
function manually_load_plugin() {
	require_once __DIR__ . '/stubs/yoast-seo.php';
	require \dirname( __DIR__ ) . '/pdf-sitemap.php';
}

// Add plugin to active mu-plugins - to make sure it gets loaded.
\tests_add_filter( 'muplugins_loaded', __NAMESPACE__ . '\manually_load_plugin' );

/*
 * Load WordPress, which will load the Composer autoload file, and load the MockObject autoloader after that.
 */
WPIntegration\bootstrap_it();
