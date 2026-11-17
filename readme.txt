=== XML Sitemap for PDFs for Yoast SEO ===
Contributors: joostdevalk, aristath, filipi
Tags: xml sitemap, pdf sitemap, yoast seo, pdf seo, seo
Requires at least: 6.7
Tested up to: 7.1.4
Requires PHP: 7.4
Stable Tag: 1.2
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

= Which PDFs does this plugin include? =

The plugin scans the uploads root and its numeric subfolders, including WordPress year/month folders, for `.pdf` files (case-insensitive). Files do not need to be registered in the media library. This intentionally includes unattached and FTP-uploaded PDFs, as well as PDFs attached to draft, private, password-protected, or scheduled posts.

The sitemap makes these files easier to discover. A parent post's visibility does not exclude its PDFs from this sitemap. Keep confidential files outside the scanned folders and protect them with access controls.

= Will this include PDFs uploaded through forms? =

PDFs uploaded through forms are included if they are stored in the uploads root or numeric subfolders. Non-numeric subfolders are not scanned.

= Does this plugin cache its output? =

Yes, the plugin caches the file list for one day, including when no PDFs are found. Uploading or permanently deleting a PDF through WordPress clears the cache automatically. Direct filesystem changes are picked up after the cache expires.

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

= 1.2 =

* Added a PDFs filter to the WordPress media library.
* Fixed caching when no PDFs are found and cleared the cache when PDF attachments are deleted.
* Improved sitemap URLs for WordPress subdirectory and index.php permalink setups.
* Added support for uppercase PDF extensions and handled missing or unreadable upload directories.
* Escaped XML output and prevented direct access to the plugin file.
* Clarified that filesystem discovery includes PDFs regardless of their parent post’s visibility.

= 1.1 =

* Fixed a bug that caused the cache not to be used.
* Fixed a bug that caused image dimensions to be missing.

= 1.0.1 =

* Fixed a potential notice for an unset variable.
* Renamed some filters for consistency.

= 1.0 =

* First release.
