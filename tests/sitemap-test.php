<?php
/**
 * Tests for the PDF sitemap output.
 *
 * @package JoostBlog\Tests
 */

namespace JoostBlog\Tests;

use JoostBlog_PDF_Sitemap;
use WPSEO_Sitemaps;
use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Tests the sitemap the plugin hands to Yoast SEO.
 *
 * @covers JoostBlog_PDF_Sitemap
 */
final class Sitemap_Test extends TestCase {

	private const BASE_URL = 'http://example.org/wp-content/uploads';

	/**
	 * Temporary uploads directory holding the fixture files.
	 *
	 * @var string
	 */
	private $uploads_dir = '';

	/**
	 * Stand-in for the Yoast SEO sitemaps object.
	 *
	 * @var WPSEO_Sitemaps
	 */
	private $sitemaps;

	/**
	 * Creates the fixture uploads directory and the Yoast SEO stand-in.
	 *
	 * @return void
	 */
	public function set_up() {
		parent::set_up();

		$this->uploads_dir = \trailingslashit( \get_temp_dir() ) . \uniqid( 'pdf-sitemap-tests-', true );

		$this->add_file( '2024/01/first.pdf', '2024-01-15 10:00:00' );
		$this->add_file( '2024/02/second file.pdf', '2024-02-20 12:30:00' );
		$this->add_file( '2023/11/UPPERCASE.PDF', '2023-11-05 08:00:00' );
		$this->add_file( '2024/02/image.png', '2024-03-01 00:00:00' );
		$this->add_file( 'cache/hidden.pdf', '2024-03-01 00:00:00' );

		\add_filter( 'upload_dir', [ $this, 'filter_upload_dir' ] );
		\delete_transient( JoostBlog_PDF_Sitemap::TRANSIENT );

		$this->sitemaps = new WPSEO_Sitemaps();
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- This is the global Yoast SEO sets.
		$GLOBALS['wpseo_sitemaps'] = $this->sitemaps;
	}

	/**
	 * Removes the fixture uploads directory and the Yoast SEO stand-in.
	 *
	 * @return void
	 */
	public function tear_down() {
		unset( $GLOBALS['wpseo_sitemaps'] );
		\remove_filter( 'upload_dir', [ $this, 'filter_upload_dir' ] );
		\delete_transient( JoostBlog_PDF_Sitemap::TRANSIENT );
		$this->remove_dir( $this->uploads_dir );

		parent::tear_down();
	}

	/**
	 * Points the uploads directory at the fixtures.
	 *
	 * @param array<string, string|false> $uploads The uploads directory data.
	 *
	 * @return array<string, string|false> The filtered uploads directory data.
	 */
	public function filter_upload_dir( $uploads ) {
		$uploads['basedir'] = $this->uploads_dir;
		$uploads['baseurl'] = self::BASE_URL;

		return $uploads;
	}

	/**
	 * The sitemap lists every PDF in the dated upload folders, newest first.
	 *
	 * @return void
	 */
	public function test_sitemap_lists_pdfs_newest_first() {
		( new JoostBlog_PDF_Sitemap() )->build_sitemap();

		$expected = \implode(
			\PHP_EOL,
			[
				'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">',
				'<url>',
				"\t<loc>" . self::BASE_URL . '/2024/02/second%20file.pdf</loc>',
				"\t<lastmod>2024-02-20T12:30:00+00:00</lastmod>",
				'</url>',
				'<url>',
				"\t<loc>" . self::BASE_URL . '/2024/01/first.pdf</loc>',
				"\t<lastmod>2024-01-15T10:00:00+00:00</lastmod>",
				'</url>',
				'<url>',
				"\t<loc>" . self::BASE_URL . '/2023/11/UPPERCASE.PDF</loc>',
				"\t<lastmod>2023-11-05T08:00:00+00:00</lastmod>",
				'</url>',
				'</urlset>',
			],
		);

		$this->assertSame( $expected, $this->sitemaps->sitemap );
	}

	/**
	 * The sitemap is well-formed XML.
	 *
	 * @return void
	 */
	public function test_sitemap_is_well_formed_xml() {
		( new JoostBlog_PDF_Sitemap() )->build_sitemap();

		$xml = \simplexml_load_string( $this->sitemaps->sitemap );

		$this->assertNotFalse( $xml );
		$this->assertCount( 3, $xml->url );
	}

	/**
	 * Other file types, and PDFs outside the folders WordPress creates, are left out.
	 *
	 * @return void
	 */
	public function test_sitemap_skips_other_files_and_folders() {
		( new JoostBlog_PDF_Sitemap() )->build_sitemap();

		$this->assertStringNotContainsString( 'image.png', $this->sitemaps->sitemap );
		$this->assertStringNotContainsString( 'hidden.pdf', $this->sitemaps->sitemap );
	}

	/**
	 * The filetypes filter adds other extensions to the sitemap.
	 *
	 * @return void
	 */
	public function test_filetypes_filter_adds_extensions() {
		$add_png = static function ( $filetypes ) {
			$filetypes[] = 'PNG';

			return $filetypes;
		};

		\add_filter( 'JoostBlog\WP\pdf_sitemap\filetypes', $add_png );
		( new JoostBlog_PDF_Sitemap() )->build_sitemap();
		\remove_filter( 'JoostBlog\WP\pdf_sitemap\filetypes', $add_png );

		$this->assertStringContainsString( '/2024/02/image.png</loc>', $this->sitemaps->sitemap );
	}

	/**
	 * An uploads directory that does not exist gives an empty sitemap, not a warning.
	 *
	 * @return void
	 */
	public function test_missing_uploads_dir_gives_empty_sitemap() {
		$this->remove_dir( $this->uploads_dir );

		( new JoostBlog_PDF_Sitemap() )->build_sitemap();

		$this->assertSame(
			'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">' . \PHP_EOL . '</urlset>',
			$this->sitemaps->sitemap,
		);
	}

	/**
	 * The second build is served from the transient, even when the files have changed.
	 *
	 * @return void
	 */
	public function test_second_build_is_served_from_cache() {
		$plugin = new JoostBlog_PDF_Sitemap();
		$plugin->build_sitemap();

		$this->add_file( '2024/03/third.pdf', '2024-03-10 09:00:00' );
		$plugin->build_sitemap();

		$this->assertStringStartsWith( '<!-- Served from cache -->', $this->sitemaps->sitemap );
		$this->assertStringNotContainsString( 'third.pdf', $this->sitemaps->sitemap );
	}

	/**
	 * Uploading or deleting a PDF clears the cache; other attachments leave it alone.
	 *
	 * @return void
	 */
	public function test_cache_is_cleared_for_pdf_attachments_only() {
		$plugin = new JoostBlog_PDF_Sitemap();
		$image  = self::factory()->attachment->create( [ 'post_mime_type' => 'image/png' ] );
		$pdf    = self::factory()->attachment->create( [ 'post_mime_type' => 'application/pdf' ] );

		$plugin->build_sitemap();

		$plugin->maybe_clear_attachment_cache( $image );
		$this->assertNotFalse( \get_transient( JoostBlog_PDF_Sitemap::TRANSIENT ) );

		$metadata = [ 'filesize' => 123 ];
		$this->assertSame( $metadata, $plugin->maybe_clear_cache( $metadata, $pdf ) );
		$this->assertFalse( \get_transient( JoostBlog_PDF_Sitemap::TRANSIENT ) );
	}

	/**
	 * The sitemap is registered with Yoast SEO and added to the sitemap index.
	 *
	 * @return void
	 */
	public function test_sitemap_is_registered_and_linked_from_the_index() {
		$plugin = new JoostBlog_PDF_Sitemap();
		$plugin->register_hooks();

		$this->assertSame( [ $plugin, 'build_sitemap' ], $this->sitemaps->registered['pdf_files'] );

		$plugin->build_sitemap();
		$links = $plugin->add_index_link( [] );

		$this->assertSame(
			[
				[
					'loc'     => 'http://example.org/pdf_files-sitemap.xml',
					'lastmod' => '2024-02-20T12:30:00+00:00',
				],
			],
			$links,
		);
	}

	/**
	 * The stylesheet handed to Yoast SEO points at the XSL file in the plugin.
	 *
	 * @return void
	 */
	public function test_stylesheet_points_at_the_plugin_xsl() {
		( new JoostBlog_PDF_Sitemap() )->build_sitemap();

		$this->assertStringContainsString( '<?xml-stylesheet type="text/xsl" href="', $this->sitemaps->renderer->stylesheet );
		$this->assertStringContainsString( '/pdf-sitemap.xsl"?>', $this->sitemaps->renderer->stylesheet );
	}

	/**
	 * Adds a fixture file with a fixed modification time.
	 *
	 * @param string $path     Path of the file, relative to the uploads directory.
	 * @param string $modified Modification time, in UTC.
	 *
	 * @return void
	 */
	private function add_file( string $path, string $modified ): void {
		$file = $this->uploads_dir . '/' . $path;

		\wp_mkdir_p( \dirname( $file ) );
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_touch -- Test fixture needs a fixed mtime.
		\touch( $file, \strtotime( $modified . ' UTC' ) );
	}

	/**
	 * Removes a fixture directory and everything in it.
	 *
	 * @param string $dir The directory to remove.
	 *
	 * @return void
	 */
	private function remove_dir( string $dir ): void {
		if ( ! \is_dir( $dir ) ) {
			return;
		}

		foreach ( \array_diff( \scandir( $dir ), [ '.', '..' ] ) as $entry ) {
			$path = $dir . '/' . $entry;
			if ( \is_dir( $path ) ) {
				$this->remove_dir( $path );
				continue;
			}
			// phpcs:ignore WordPress.WP.AlternativeFunctions.unlink_unlink -- Test fixture clean-up.
			\unlink( $path );
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_rmdir -- Test fixture clean-up.
		\rmdir( $dir );
	}
}
