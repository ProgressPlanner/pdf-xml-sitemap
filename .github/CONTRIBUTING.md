# Contribution Guidelines

Thanks for your interest in improving XML Sitemap for PDFs for Yoast SEO.

## Before you open an issue

We use GitHub for well-documented bugs, feature requests, and code contributions.

- For usage questions or general support, please use the [WordPress.org support forum](https://wordpress.org/support/plugin/pdf-sitemap/).
- For security issues, please follow our [security policy](https://github.com/ProgressPlanner/pdf-xml-sitemap/security/policy) and do not open a public issue.

Before opening a new issue, please:

- make sure you are using the latest version of WordPress, Yoast SEO, and this plugin;
- search existing issues to avoid duplicates;
- include clear reproduction steps, expected behavior, and actual behavior;
- add screenshots, URLs, or other context when helpful.

## Submitting a pull request

Community contributions are welcome.

1. Fork the repository.
2. Create a branch for your change.
3. Make your changes.
4. Follow the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) and document any new hooks or functions.
5. Run the relevant checks before submitting.
6. Open a pull request against the `main` branch.

## Development notes

- Keep changes focused and easy to review.
- Reference the related issue when possible.
- Update documentation when behavior changes.

## Publishing readme updates

After merging a readme-only change into `main`, run **Sync readme.txt to WordPress.org** from GitHub Actions on `main`. It updates only `readme.txt` in SVN trunk and the existing stable tag, using the same SVN secrets as releases. It refuses to change the published stable version and shares a concurrency group with release deployments. No new plugin release is needed.

For a read-only preview, run `DRY_RUN=true bash .github/scripts/sync-readme.sh`.

## Useful links

- [Open issues](https://github.com/ProgressPlanner/pdf-xml-sitemap/issues)
- [New issue](https://github.com/ProgressPlanner/pdf-xml-sitemap/issues/new/choose)
- [WordPress.org plugin page](https://wordpress.org/plugins/pdf-sitemap/)
