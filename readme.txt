=== XML Sitemap for PDFs for Yoast SEO ===
Contributors: joostdevalk, aristath, filipi
Tags: xml sitemap, pdf sitemap, yoast seo, pdf seo, seo
Requires at least: 6.7
Tested up to: 6.9
Requires PHP: 7.4
Stable Tag: 1.1
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Automatically add PDF files from your WordPress uploads directory to Yoast SEO's XML sitemap index so search engines can discover and crawl them more easily.

== Description ==

XML Sitemap for PDFs for Yoast SEO creates a dedicated XML sitemap for PDFs stored in your WordPress uploads folder and adds it to Yoast SEO's `sitemap_index.xml` automatically.

If your site publishes brochures, manuals, menus, research papers, whitepapers, downloadable guides, or other PDF resources, this plugin helps search engines find those files faster.

= Why site owners use this plugin =

* Automatically creates a dedicated PDF sitemap.
* Adds that sitemap to Yoast SEO's sitemap index.
* Works in the background with no settings to configure.
* Uses caching for performance.
* Clears the cache when a new PDF is uploaded.
* Includes filters for developers who need custom behavior.

= Important note =

This plugin requires [Yoast SEO](https://yoast.com/wordpress/plugins/seo/) and is designed specifically to extend Yoast SEO's sitemap system.

= Need help or want to report an issue? =

* Support: [WordPress.org support forum](https://wordpress.org/support/plugin/pdf-sitemap/)
* Bugs and feature requests: [GitHub repository](https://github.com/ProgressPlanner/pdf-xml-sitemap)
* Security reports: [Patchstack vulnerability disclosure program](https://patchstack.com/database/vdp/pdf-sitemap)

== Installation ==

= Install from your WordPress dashboard =

1. Go to Plugins > Add New.
2. Search for "XML Sitemap for PDFs for Yoast SEO".
3. Click Install Now.
4. Activate the plugin.

= Install manually =

1. Download the plugin from WordPress.org.
2. Upload the plugin files to the `/wp-content/plugins/pdf-sitemap/` directory.
3. Activate the plugin through the Plugins menu in WordPress.

== Frequently Asked Questions ==

= How do I know it is working? =

After activation, visit your site's `sitemap_index.xml`. You should see a link to `pdf_files-sitemap.xml`.

= Will this include PDFs uploaded through forms? =

Not always. The plugin scans WordPress-style numeric uploads folders, so PDFs stored outside that structure may not be included.

= Does this plugin cache its output? =

Yes. The plugin scans the uploads folder once per day and stores the result in a transient. When you upload a new PDF file, that cache is cleared automatically.

= Does this plugin work with SEO plugins other than Yoast SEO? =

No. This plugin only works with Yoast SEO.

= Does this plugin work on multisite? =

Multisite support has not been officially tested.

= Are there developer hooks available? =

Yes. The plugin includes these filters:

* `JoostBlog\WP\pdf_sitemap\filetypes` to change which file extensions are included.
* `JoostBlog\WP\pdf_sitemap\cache_time` to change the cache duration.
* `JoostBlog\WP\pdf_sitemap\pdfs` to filter the final list of sitemap entries.

== Screenshots ==

1. Example PDF XML sitemap.
2. Example of the PDF XML sitemap linked in the sitemap index.

== Changelog ==

= 1.1 =

* Fixed a bug that caused the cache not to be used.
* Fixed a bug that caused image dimensions to be missing.

= 1.0.1 =

* Fixed a potential notice for an unset variable.
* Renamed some filters for consistency.

= 1.0 =

* First release.
