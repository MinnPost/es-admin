<?php
/**
 * VIP Search adapter. This does not work yet.
 *
 * @package ES Admin
 */

namespace ES_Admin\Adapters;

/**
 * A generic ES implementation for Travis CI
 */
class VIP_Search extends Adapter {

    /**
	 * Build the object and set the field map.
	 */
	public function __construct() {

        // Modify the response so it's in a format ES Admin understands.
		add_filter( 'es_admin_results', [ $this, 'filter_es_admin_results' ] );

        $this->field_map['post_author']                   = 'post_author.id';
        $this->field_map['post_author.user_nicename']     = 'post_author.login.raw';
        $this->field_map['post_date']                     = 'post_date';
        $this->field_map['post_date.year']                = 'date_terms.year';
        $this->field_map['post_date.month']               = 'date_terms.month';
        $this->field_map['post_date.week']                = 'date_terms.week';
        $this->field_map['post_date.day']                 = 'date_terms.day';
        $this->field_map['post_date.day_of_year']         = 'date_terms.dayofyear';
        $this->field_map['post_date.day_of_week']         = 'date_terms.dayofweek';
        $this->field_map['post_date.hour']                = 'date_terms.hour';
        $this->field_map['post_date.minute']              = 'date_terms.minute';
        $this->field_map['post_date.second']              = 'date_terms.second';
        $this->field_map['post_date_gmt']                 = 'post_date_gmt';
        $this->field_map['post_date_gmt.year']            = 'date_gmt_terms.year';
        $this->field_map['post_date_gmt.month']           = 'date_gmt_terms.month';
        $this->field_map['post_date_gmt.week']            = 'date_gmt_terms.week';
        $this->field_map['post_date_gmt.day']             = 'date_gmt_terms.day';
        $this->field_map['post_date_gmt.day_of_year']     = 'date_gmt_terms.day_of_year';
        $this->field_map['post_date_gmt.day_of_week']     = 'date_gmt_terms.day_of_week';
        $this->field_map['post_date_gmt.hour']            = 'date_gmt_terms.hour';
        $this->field_map['post_date_gmt.minute']          = 'date_gmt_terms.minute';
        $this->field_map['post_date_gmt.second']          = 'date_gmt_terms.second';
        $this->field_map['post_content']                  = 'post_content';
        $this->field_map['post_content.analyzed']         = 'post_content';
        $this->field_map['post_title']                    = 'post_title.raw';
        $this->field_map['post_title.analyzed']           = 'post_title';
        $this->field_map['post_type']                     = 'post_type.raw';
        $this->field_map['post_excerpt']                  = 'post_excerpt';
        $this->field_map['post_password']                 = 'post_password';  // This isn't indexed on VIP.
        $this->field_map['post_name']                     = 'post_name.raw';
        $this->field_map['post_modified']                 = 'post_modified';
        $this->field_map['post_modified.year']            = 'modified_date_terms.year';
        $this->field_map['post_modified.month']           = 'modified_date_terms.month';
        $this->field_map['post_modified.week']            = 'modified_date_terms.week';
        $this->field_map['post_modified.day']             = 'modified_date_terms.day';
        $this->field_map['post_modified.day_of_year']     = 'modified_date_terms.day_of_year';
        $this->field_map['post_modified.day_of_week']     = 'modified_date_terms.day_of_week';
        $this->field_map['post_modified.hour']            = 'modified_date_terms.hour';
        $this->field_map['post_modified.minute']          = 'modified_date_terms.minute';
        $this->field_map['post_modified.second']          = 'modified_date_terms.second';
        $this->field_map['post_modified_gmt']             = 'post_modified_gmt';
        $this->field_map['post_modified_gmt.year']        = 'modified_date_gmt_terms.year';
        $this->field_map['post_modified_gmt.month']       = 'modified_date_gmt_terms.month';
        $this->field_map['post_modified_gmt.week']        = 'modified_date_gmt_terms.week';
        $this->field_map['post_modified_gmt.day']         = 'modified_date_gmt_terms.day';
        $this->field_map['post_modified_gmt.day_of_year'] = 'modified_date_gmt_terms.day_of_year';
        $this->field_map['post_modified_gmt.day_of_week'] = 'modified_date_gmt_terms.day_of_week';
        $this->field_map['post_modified_gmt.hour']        = 'modified_date_gmt_terms.hour';
        $this->field_map['post_modified_gmt.minute']      = 'modified_date_gmt_terms.minute';
        $this->field_map['post_modified_gmt.second']      = 'modified_date_gmt_terms.second';
        $this->field_map['post_parent']                   = 'post_parent';
        $this->field_map['menu_order']                    = 'menu_order';
        $this->field_map['post_mime_type']                = 'post_mime_type';
        $this->field_map['comment_count']                 = 'comment_count';
        $this->field_map['post_meta']                     = 'meta.%s.value.sortable';
        $this->field_map['post_meta.analyzed']            = 'meta.%s.value';
        $this->field_map['post_meta.long']                = 'meta.%s.long';
        $this->field_map['post_meta.double']              = 'meta.%s.double';
        $this->field_map['post_meta.binary']              = 'meta.%s.boolean';
        $this->field_map['term_id']                       = 'terms.%s.term_id';
        $this->field_map['term_slug']                     = 'terms.%s.slug';
        $this->field_map['term_name']                     = 'terms.%s.name.sortable';
        $this->field_map['category_id']                   = 'terms.category.term_id';
        $this->field_map['category_slug']                 = 'terms.category.slug';
        $this->field_map['category_name']                 = 'terms.category.name.sortable';
        $this->field_map['tag_id']                        = 'terms.post_tag.term_id';
        $this->field_map['tag_slug']                      = 'terms.post_tag.slug';
        $this->field_map['tag_name']                      = 'terms.post_tag.name.sortable';
    }

    /**
	 * Run a query against the ES index.
	 *
	 * @param  array $es_args Elasticsearch DSL as a PHP array.
	 * @return array Elasticsearch response as a PHP array.
	 */
	public function query( $es_args ) {
        $result = array();
        if ( class_exists( '\\Automattic\\VIP\\Search\\Search' ) ) {
			$vip_search = \Automattic\VIP\Search\Search::instance();
			if ( method_exists( $vip_search, 'query_es' ) ) {
                /**
				 * Modify the underlying ES query that is passed to the search endpoint.
				 * The returned args must represent a valid ES query (ES DSL). This
				 * filter mimics the `jetpack_search_es_query_args` filter.
				 *
				 * This filter is hard to use if you're unfamiliar with ES, but allows
				 * complete control over the query.
				 *
				 * @param array $es_args The raw Elasticsearch query args (DSL).
				 * @return array Elasticsearch DSL.
				 */

				$es_args = apply_filters( 'es_admin_jp_es_query_args', $es_args );
				$result = $vip_search->query_es( 'post', $es_args );
                //$result   = $this->normalize_result( $result );
                //$result = $this->set_posts( $result );
                
                
			}
		}
        return $result;
    }

    /**
	 * Filter the ES Admin result so it matches what ES Admin expects.
	 *
	 * @param array $results Query results.
	 * @return array
	 */
	public function filter_es_admin_results( $results ) {

		foreach ( $results as $result ) {

        }
        return $results;
	}

    /**
	 * Sets the posts array to the list of found post IDs.
	 *
	 * @param array          $q           Query arguments.
	 * @param array|WP_Error $es_response Response from VIP Search.
	 * @access protected
	 */
	function normalize_result( $result ) {
		// Normalize response (ES is hits.hits, wpcom is results.hits; ES is
        // aggregations, wpcom is results.aggregations).
        return $result;
	}
}
