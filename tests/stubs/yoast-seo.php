<?php
/**
 * Minimal stand-ins for the Yoast SEO sitemap classes this plugin talks to.
 *
 * Used by PHPStan (so the classes are known) and by the test suite (so the
 * sitemap can be built without Yoast SEO being installed).
 *
 * @package JoostBlog\Tests
 */

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound -- Three small stand-ins in one file.
// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses -- Three small stand-ins in one file.
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace -- Mirrors the global Yoast SEO class names.
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- Mirrors the Yoast SEO class names.
// phpcs:disable Universal.Classes.RequireFinalClass.NonFinalClassFound -- The real classes are not final.

/**
 * Stand-in for the Yoast SEO sitemap renderer.
 */
class WPSEO_Sitemaps_Renderer {

	/**
	 * The stylesheet line that was set.
	 *
	 * @var string
	 */
	public $stylesheet = '';

	/**
	 * Sets the stylesheet line.
	 *
	 * @param string $stylesheet Full XML-stylesheet declaration.
	 *
	 * @return void
	 */
	public function set_stylesheet( $stylesheet ) {
		$this->stylesheet = $stylesheet;
	}
}

/**
 * Stand-in for the Yoast SEO sitemap router.
 */
class WPSEO_Sitemaps_Router {

	/**
	 * Returns the absolute URL of a sitemap page.
	 *
	 * @param string $page Page to append to the base URL.
	 *
	 * @return string Base URL (incl. page).
	 */
	public static function get_base_url( $page ) {
		return home_url( '/' . $page );
	}
}

/**
 * Stand-in for the Yoast SEO sitemaps class.
 */
class WPSEO_Sitemaps {

	/**
	 * The sitemap renderer.
	 *
	 * @var WPSEO_Sitemaps_Renderer
	 */
	public $renderer;

	/**
	 * The sitemap content that was set.
	 *
	 * @var string
	 */
	public $sitemap = '';

	/**
	 * The registered sitemap callbacks, keyed by sitemap name.
	 *
	 * @var array<string, callable>
	 */
	public $registered = [];

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->renderer = new WPSEO_Sitemaps_Renderer();
	}

	/**
	 * Registers a sitemap.
	 *
	 * @param string   $name              The name of the sitemap.
	 * @param callable $building_function Function to build the sitemap.
	 *
	 * @return void
	 */
	public function register_sitemap( $name, $building_function ) {
		$this->registered[ $name ] = $building_function;
	}

	/**
	 * Sets the sitemap content.
	 *
	 * @param string $sitemap The generated sitemap XML.
	 *
	 * @return void
	 */
	public function set_sitemap( $sitemap ) {
		$this->sitemap = $sitemap;
	}
}
