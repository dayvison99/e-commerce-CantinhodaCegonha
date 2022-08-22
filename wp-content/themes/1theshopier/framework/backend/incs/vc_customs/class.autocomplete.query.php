<?php 

if( !class_exists( "Theshopier_VC_Autocomplete_Query" ) ) {
	
	abstract class Theshopier_VC_Autocomplete_Query {
		
		public function query_post_where( $where, &$wp_query ){
			global $wpdb;
			if( $search_term = $wp_query->get( '_search' ) ) {
				$like_str = esc_sql( $wpdb->esc_like( $search_term ) );
				$where .= ' AND (('.$wpdb->posts.'.post_title LIKE \'%' . $like_str . '%\')';
				$where .= ' OR ('.$wpdb->posts.'.ID LIKE \'%' . $like_str . '%\')';
				$where .= ' OR ('.$wpdb->posts.'.post_name LIKE \'%' . $like_str . '%\')';
				$where .= ')';
			}
			return $where;
		}
		
		public function get_productCat_callback( $query ){
			global $wpdb;
			$cat_id = (int) $query;
			$query = trim( $query );
			$post_meta_infos = $wpdb->get_results(
				$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
								FROM {$wpdb->term_taxonomy} AS a
								INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
								WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
					$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) )
			, ARRAY_A );

			$result = array();
			if ( is_array( $post_meta_infos ) && !empty( $post_meta_infos ) ) {
				foreach ( $post_meta_infos as $value ) {
					$data = array();
					$data['value'] = $value['slug'];
					$data['label'] = 'ID' . ': ' .
										 $value['id'] .
										 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'theshopier' ) . ': ' .
																			  $value['name'] : '' ) .
										 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'theshopier' ) . ': ' .
																		  $value['slug'] : '' );
					$result[] = $data;
				}
			}

			return $result;
		}
		
		public function get_productCat_render( $query ){
			$query = $query['value'];
			$slug = esc_attr($query);
			$term = get_term_by( 'slug', $slug, 'product_cat' );
			
			$term_slug = $term->slug;
			$term_title = $term->name;
			$term_id = $term->term_id;

			$term_slug_display = '';
			if ( !empty( $term_slug ) ) {
				$term_slug_display = ' - ' . esc_html__( 'Slug', 'theshopier' ) . ': ' . $term_slug;
			}

			$term_title_display = '';
			if ( !empty( $term_title ) ) {
				$term_title_display = ' - ' . esc_html__( 'Name', 'theshopier' ) . ': ' . $term_title;
			}

			$term_id_display = esc_html__( 'ID', 'theshopier' ) . ': ' . $term_id;

			$data = array();
			$data['value'] = $term_slug;
			$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

			return !empty( $data ) ? $data : false;
		}
		
		public function get_postType_id_callback( $query, $post_type = '' ){
			if( strlen($post_type) == 0 ) return array();
			$query = trim( $query );
			
			$args_post = array(
				'post_type' 		=> $post_type,
				'posts_per_page'	=> 12,
				'post_status' 		=> 'publish',
				'ignore_sticky_posts' => 1,
				'orderby'     		=> 'title', 
				'order'       		=> 'ASC',
				'_search'				=> $query,
			);
			
			add_filter( 'posts_where', array( $this, 'query_post_where'), 10, 2 );
			$post_meta_infos = new WP_Query($args_post);
			remove_filter( 'posts_where', array( $this, 'query_post_where'), 10, 2 );

			$result = array();
			
			if( $post_meta_infos->have_posts() ): 
			
				while ( $post_meta_infos->have_posts() ) : $post_meta_infos->the_post();
					$data = array();
					$data['value'] = get_the_id();
					$data['label'] = 'ID' . ': ' . get_the_id()
							. ( ( strlen( get_the_title() ) > 0 ) ? ' - ' . 'Name' . ': ' . get_the_title() : '' );
					$result[] = $data;
				endwhile;
			
			endif;
			
			wp_reset_postdata();
			
			return $result;
		}
		
		public function get_postType_id_render( $query, $post_type = '' ){
			if(strlen($post_type) == 0) return false;
			$query = $query['value'];
			$id = (int) $query;
			$args = array(
				'post_type'			=> $post_type,
				'posts_per_page' 	=> 1,
				'include'			=> $id,
				'post_status'		=> 'publish',
			);
			$_post = get_posts($args);
			if ( ! is_wp_error( $_post ) && is_array( $_post ) && count( $_post ) > 0 ) {
				foreach ( $_post as $k => $v ) {
					$data = array();
					$data['value'] = $v->ID;
					$data['label'] = 'ID' . ': ' . $v->ID
							. ( ( strlen( $v->post_title ) > 0 ) ? ' - ' . 'Name' . ': ' . $v->post_title : '' );
				}
			}
			wp_reset_postdata();
			return !empty( $data ) ? $data : false;
		}
		
		public function get_term_by_callback( $query, $taxonomy = '', $field = 'id' ){
			if(strlen(trim($taxonomy)) == 0) return array();
			global $wpdb;
			$cat_id = (int) $query;
			$query = trim( $query );
			$post_meta_infos = $wpdb->get_results(
				$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
								FROM {$wpdb->term_taxonomy} AS a
								INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
								WHERE a.taxonomy = '{$taxonomy}' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
					$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) )
			, ARRAY_A );

			$result = array();
			if ( is_array( $post_meta_infos ) && !empty( $post_meta_infos ) ) {
				foreach ( $post_meta_infos as $value ) {
					$data = array();
					$data['value'] = strcmp(trim($field), 'id') == 0? $value['id']: $value['slug'];
					$data['label'] = 'ID' . ': ' .
										 $value['id'] .
										 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'theshopier' ) . ': ' .
																			  $value['name'] : '' ) .
										 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'theshopier' ) . ': ' .
																		  $value['slug'] : '' );
					$result[] = $data;
				}
			}
			
			return $result;
		}
		
		public function get_term_by_render( $query, $taxonomy = '', $field = 'id' ){
			if(strlen(trim($taxonomy)) == 0) return false;
			$query = $query['value'];
			$slug = esc_attr($query);
			$term = get_term_by( $field, $slug, $taxonomy );
			
			$term_slug = $term->slug;
			$term_title = $term->name;
			$term_id = $term->term_id;

			$term_slug_display = '';
			if ( !empty( $term_slug ) ) {
				$term_slug_display = ' - ' . esc_html__( 'Slug', 'theshopier' ) . ': ' . $term_slug;
			}

			$term_title_display = '';
			if ( !empty( $term_title ) ) {
				$term_title_display = ' - ' . esc_html__( 'Name', 'theshopier' ) . ': ' . $term_title;
			}

			$term_id_display = esc_html__( 'ID', 'theshopier' ) . ': ' . $term_id;

			$data = array();
			$data['value'] = strcmp(trim($field), 'id') == 0? $term_id: $term_slug;
			$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

			return !empty( $data ) ? $data : false;
		}
	}
	
}
