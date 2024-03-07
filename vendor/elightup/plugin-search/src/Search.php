<?php
namespace eLightUp\PluginSearch;

class Search extends Base {
	public function suggests() {
		$term = $this->sanitize_search_term( $this->args->search );
		$data = $this->data();
		foreach ( $data as $plugin ) {
			if ( strpos( $plugin['keywords'], $term ) !== false ) {
				$this->insert( $plugin['slug'], $plugin['position'] );
			}
		}
	}

	private function sanitize_search_term( $term ) {
		$term = strtolower( urldecode( $term ) );
		$term = preg_replace( '/[^a-z0-9 ]/', '', $term );

		// Remove strings that don't help matches.
		$term = trim( str_replace( [ 'free', 'wordpress' ], '', $term ) );
		$term = preg_replace( '/\s{2,}/', ' ', $term );

		return $term;
	}

	private function data(): array {
		return apply_filters( 'eps_search', [
			[
				'slug'     => 'slim-seo',
				'position' => 1,
				'keywords' => '
					rank, google, bing, yandex, search engines, search results, optimize, optimization,
					yoast seo, rank math, rankmath, seopress,
					xml sitemaps,
					schemas, rich snippets, structured data,
					meta tags, meta title, meta description, robots, noindex, canonical url, open graph, opengraph, twitter cards,
					social networks, social media, social preview, facebook, twitter,
					breadcrumbs,
					permalink structure,
					content analysis, content readability, seo audit, seo keywords,
					internal links, internal linking,
					redirects, redirection, 404 redirects, 301 redirects,
					local seo, woocommerce seo,
					image seo, image alt,
					rss feed, content protection,
					header code, header footer code, insert code, insert footers, insert headers and footers, javascript code snippets, css code snippets, html code snippets,
					google analytics, google tag manager, google conversion pixels, google adsense ads code, amazon native contextual ads code, media ads code, facebook pixels, tracking code, tracking scripts, header scripts, footer scripts,
					site verification meta tags, google search console, domain verification,
					',
			],
			[
				'slug'     => 'falcon',
				'position' => 1,
				'keywords' => '
					optimize, optimization, speed, performance, tweak,
					heartbeat, emojis, embed, ping, css, js, javascript, comment, widget, header, xml-rpc, xmlrpc
					',
			],
		] );
	}

	protected function validate(): bool {
		return ! empty( $this->args->search ) && is_string( $this->args->search ) && strlen( $this->args->search ) >= 3;
	}
}
