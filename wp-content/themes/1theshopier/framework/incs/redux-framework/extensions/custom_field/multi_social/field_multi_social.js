/*global redux_change, redux*/

(function( $ ) {
    "use strict";

    redux.field_objects = redux.field_objects || {};
    redux.field_objects.multi_social = redux.field_objects.multi_social || {};

    $( document ).ready(
        function() {
            //redux.field_objects.multi_text.init();
        }
    );
	
	
    redux.field_objects.multi_social.init = function( selector ) {

        if ( !selector ) {
            selector = $( document ).find( '.redux-container-multi_social:visible' );
        }

        $( selector ).each(
            function() {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }
                if ( parent.is( ":hidden" ) ) { // Skip hidden fields
                    return;
                }
                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }
				
				var default_params = {
					width: 'resolve',
					triggerChange: true,
					allowClear: true
				};
				
				el.find( 'select.redux-select-item' ).each(
                    function() {
						
                        if ( $( this ).siblings( '.select2_params' ).size() > 0 ) {
                            var select2_params = $( this ).siblings( '.select2_params' ).val();
                            select2_params = JSON.parse( select2_params );
                            default_params = $.extend( {}, default_params, select2_params );
                        }

                        if ( $( this ).hasClass( 'font-icons' ) ) {
                            default_params = $.extend(
                                {}, {
                                    formatResult: redux.field_objects.multi_social.addIcon,
                                    formatSelection: redux.field_objects.multi_social.addIcon,
                                    escapeMarkup: function( m ) {
                                        return m;
                                    }
                                }, default_params
                            );
                        }

                        $( this ).select2( default_params );
						
                    }
                );
				
                el.find( '.nth-multi-socials-remove' ).live(
                    'click', function() {
                        redux_change( $( this ) );
                        $( this ).prev( 'input[type="text"]' ).val( '' );
                        $( this ).parents('li').slideUp(
                            'medium', function() {
                                $( this ).remove();
                            }
                        );
                    }
                );

                el.find( '.nth-multi-socials-add' ).on('click',
                    function() {
						
                        var number = parseInt( $( this ).attr( 'data-add_number' ) );
                        var id = $( this ).attr( 'data-id' );
						var key = parseInt( $(this).attr( 'data-name_number' ) );
                        var name_link = $( this ).attr( 'data-name' )+'['+key+']'+'[link]';
						var name_icon = $( this ).attr( 'data-name' )+'['+key+']'+'[icon]';
						
						default_params = $.extend(
							{}, {
								formatResult: redux.field_objects.multi_social.addIcon,
								formatSelection: redux.field_objects.multi_social.addIcon,
								escapeMarkup: function( m ) {
									return m;
								}
							}, default_params
						);
						
                        for ( var i = 0; i < number; i++ ) {
                            var new_input = $( '#' + id + ' li.item-template' ).clone();
							console.log(new_input);
                            el.find( '#' + id ).append( new_input );
                            el.find( '#' + id + ' li:last-child' ).removeAttr( 'style' ).removeClass('item-template');
                            el.find( '#' + id + ' li:last-child input[type="text"]' ).val( '' );
                            el.find( '#' + id + ' li:last-child input[type="text"]' ).attr( 'name', name_link );
							el.find( '#' + id + ' li:last-child select' ).attr( 'name', name_icon );
							el.find( '#' + id + ' li:last-child select' ).select2(default_params);
                        }
						
						$(this).attr('data-name_number', key+1 );
						
                    }
                );
            }
        );
    };
	
	
	redux.field_objects.multi_social.addIcon = function( icon ) {
        if ( icon.hasOwnProperty( 'id' ) ) {
            return "<span class='font-awesome-icon'><i class='" + icon.id + "'></i>" + "&nbsp;&nbsp;" + icon.text + "</span>";
        }
    };
	
})( jQuery );