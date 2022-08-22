/**
 * wp-my-instagram
 * This only run once to reduce page load time.
 *
 * @author mnmlthms
 * @url mnmlthms
 */
;(function( $ ){

    'use strict';

    $(document).ready(function(){

        var $blocks = $('.wp-my-instagram.wpmi[data-cached="false"]');

        var data_storage = [];

        var fetch_data = function( id, args ){

            var settings = {
                    username: '',
                    hashtag: '',
                    limit: 6,
                    popular: false
                };
            

            $.extend( true, settings, args );


            var username = settings.username || false,
                hashtag = settings.hashtag || false,
                hashtag_popular = settings.popular || false,
                base_url = 'https://instagram.com/',
                url = base_url + username;


            if( !username && !hashtag ){
                console.log( 'No hashtag or username provided.');
                return;
            }

            // if use hashtag
            if( hashtag ){
                url = base_url + 'explore/tags/' + hashtag;
            }

            $.ajax({
                type: 'GET',
                url: url,
                async: true,
                cache: false
            }).done( function (data) {
                    
                if( hashtag ){
                    var hashtag_media_key = hashtag_popular ? 'edge_hashtag_to_top_posts' : 'edge_hashtag_to_media';
                    
                    data = JSON.parse(data.split("window._sharedData = ")[1].split(";<\/script>")[0]).entry_data.TagPage[0].graphql.hashtag[hashtag_media_key].edges;
                }else{
                    data = JSON.parse(data.split("window._sharedData = ")[1].split(";<\/script>")[0]).entry_data.ProfilePage[0].graphql.user.edge_owner_to_timeline_media.edges;
                }

                if( data ){
                    
                    var images = [];

                    for (var property in data) {
                        var image_data = data[property]['node'];
                        var image_args = {};
                        
                        // thumbnail
                        image_args['thumbnail'] = ( ( image_data || {} ).thumbnail_resources[0] || {} ).src || '';

                        // xsmall
                        image_args['xsmall'] = ( ( image_data || {} ).thumbnail_resources[1] || {} ).src || '';

                        // small
                        image_args['small'] = ( ( image_data || {} ).thumbnail_resources[2] || {} ).src || '';

                        // medium
                        image_args['medium'] = ( ( image_data || {} ).thumbnail_resources[3] || {} ).src || '';

                        // Large
                        image_args['large'] = ( image_data || {} ).thumbnail_src || '';

                        // Full
                        image_args['original'] = ( image_data || {} ).display_url || '';;

                        // link
                        image_args['url'] = image_data.shortcode ? '//instagram.com/p/' + image_data.shortcode : '';

                        // type
                        image_args['type'] = image_data.is_video ? 'video' : 'image';

                        // description
                        image_args['description'] = (((( image_data || {} ).edge_media_to_caption || {}).edges[0] || {} ).node || {} ).text || '';

                        // time
                        image_args['time'] = image_data['taken_at_timestamp'] || '';

                        // Comments:
                        image_args['comments'] = (( image_data || {} ).edge_media_to_comment || {}).count || '';

                        // Likes
                        image_args['likes'] = image_data['edge_liked_by']['count'] || '';

                        // finally push image data to images
                        images[images.length] = image_args;

                        // Break when reaches the limit
                        if( images.length === parseInt(settings.limit) ){
                            break;
                        }
                    }

                    if( images.length ){
                        $(document.body).trigger( 'wp-my-instagram-load', { id: id, args: settings, images: images } );
                    }

                }
                
            });
        }

        // fetch_data({ username: 'aesthetic', limit: 7, hashtag: 'pixel4', popular: false });
        // fetch_data({ username: 'aesthetic', limit: 10, hashtag: '', popular: false });


        $(document.body).on( 'wp-my-instagram-load', function( e, data ){

            $.ajax({
                url: wpMyInstagramVars.ajaxurl,
                type: 'POST',
                async: true,
                cache: false,
                // dataType: 'json',
                data: {
                    action: 'wpmi-request-cache',
                    security: wpMyInstagramVars.nonce,
                    data: data
                }
            }).done( function( response ){

                if( response && response.data ){
                    for (var key in response.data ) {
                        var $wmmi = $( '#' + key + '.wp-my-instagram.wpmi' );
                        $('.wpmi-list', $wmmi).html( response.data[key] ),
                        $wmmi.attr('data-cached', 'true' );
                    }

                }
                
            });
        });

        if( $blocks.length ){

            $blocks.each(function( index ){
                var $el = $(this),
                    id = $el.attr('id');

                // init data
                fetch_data( id, $el.data('args') );

            });
        }

    });

// Works with either jQuery
})( window.jQuery );
