jQuery.fn.klhpc_repeater = function(){

	return this.each(function() {

		var $el 				 = jQuery(this),
			slug					 = $el.data('slug'),
			$form_alert 	 = $el.find('#klhpc-form-alert'),
			$repeater_rows = $el.find("[data-behaviour~=klhpc-repeater-rows]"),
			rows 					 = JSON.parse($repeater_rows.text()),
			fields				 = $el.data('fields');


		var repeater = ORBIT_REPEATER( {
			$el							: $el,
			btn_text				: '+ Add IP Range',
			close_btn_text	: 'Delete IP Range',
			init	: function( repeater ){

				/*
				* INITIALIZE: CREATES THE UNLISTED LIST WHICH WILL TAKE CARE OF THE CHOICE, HIDDEN FIELD AND THE ADD BUTTON
				*/

				// ITERATE THROUGH EACH VALUES IN THE DB
				if( rows != undefined ){
					jQuery.each( rows, function( i, row ){
						repeater.addItem( row );
					});
				}

			},
			addItem	: function( repeater, $list_item, $closeButton, row ){

				/*
				* ADD LIST ITEM TO THE UNLISTED LIST
				* TEXTAREA: CHOICE TITLE
				* HIDDEN: CHOICE ID
				* HIDDEN: CHOICE COUNT
				*/


				if( row == undefined ){
					row = {};
				}

				repeater.addCollapsibleItem( $list_item, $closeButton );

				var $header = $list_item.find( '.list-header' );
				var $content = $list_item.find( '.list-content' );

				// ROW LABEL
				var $textarea = repeater.createField({
					element	: 'textarea',
					attr	: {
						'name' 				: getAttrName('label'),
						'placeholder'	: 'IP Range ' + ( repeater.count + 1 )
					},
					append	: $header
				} );

				if( row['label'] ){ $textarea.val( row['label'] ); }

				function getAttrName( field_slug ){
					return slug + '[' + repeater.count + '][' + field_slug + ']'
				}

				function getSlug( field_slug ){
					return slug + "[" + $list_item.data('count') + "]" + "[" + field_slug + "]";
				}

				function getFieldElement( field_slug ){
					var slug = getSlug( field_slug );
					return $list_item.find( '[name="' + slug + '"]' );
				}

				function getFieldContainer( field_slug ){
					return $list_item.find( '.orbit-field.orbit-field-' + field_slug );
				}

				$list_item.data( 'count', repeater.count );

				jQuery.each( fields, function( field_slug, field ){

					field.label = field.text;

					field.slug = getSlug( field_slug );

					field.value = undefined;

					if( row[ field_slug ] != undefined ){ field.value = row[ field_slug ]; }

					field.attr = {
						name: field.slug
					};

					var $containerField = repeater.createField({
						element	: 'div',
						attr	: {
							'class'	: 'orbit-field orbit-field-' + field_slug,
						},
						append	: $content
					});

					field.append = $containerField;

					switch( field.type ){
						case 'text':
							repeater.createInputTextField( field );
							break;

						case 'textarea':
							repeater.createTextareaField( field );
							break;
					}

				});

				// REMOVE WHITESPACES WHENEVER A VALUE IS CHANGED
				$list_item.on( 'change', function(){
					var $input = jQuery(this).find('input[type=text]');
					$input.prop('value', $input.val().trim());
				});

				$closeButton.click( function( ev ){
					ev.preventDefault();
					if( confirm( 'Are you sure you want to remove this?' ) ){
						$list_item.remove();
					}
				});

			},

		} );



		/* FORM VALIDATION */

		/* IP VALIDATION SNIPPET */
		function is_valid_ip(ip) {
			if (ip.match('^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$') && ip.split('.').length == 4){
				return true;
			} else {
				return false;
			}
		}

		function isValidIpRange( ip_range ){
			var ip_addresses = ip_range.split('-');

			if( ip_addresses.length != 2 ){
				return false;
			}

			if( !is_valid_ip( ip_addresses[0] ) || !is_valid_ip( ip_addresses[1] ) ){
				return false;
			}

			return true;

		}

		function validateIP( ip_range ){
			// VALIDATE AN IP_RANGE
			if(ip_range.indexOf('-') != -1) {
				if( !isValidIpRange( ip_range ) ) {
					return false;
				}
			}
			// VALIDATE A SINGLE IP_ADDRESS
			else if( !is_valid_ip( ip_range) ){
				return false;
			}

			return true;

		}

		/* IP VALIDATION SNIPPET */


		function validateForm(){
			var flag 	    = true,
				fields 			= $el.find('.orbit-field-range input');

				// LOOP THROUGH ALL THE IP_RANGE FIELDS
				jQuery.each( fields, function( i, field ){
					var $ip_range 		 = jQuery(field);
					var ip_range_val 	 = $ip_range.val();
					var alert_attrs 	 = "class='error notice orbit-ip-field-alert'";

					// CHECKS IF ANY OF THE IP_RANGE FIELDS ARE EMPTY
					if( !ip_range_val ){
						$ip_range.closest('.orbit-choice-item').append(`<div ${alert_attrs}><p>IP Address cannot be empty.</p></div>`);
						flag = false;
		      }
					else if( !validateIP( ip_range_val ) ){
						$ip_range.closest('.orbit-choice-item').append(`<div ${alert_attrs}><p>Invalid IP Address.</p></div>`);
						flag = false;
					}

		    });

			return flag;
		}

		function clearValidationErrors(){
			$form_alert.hide();
			$el.find('.orbit-choice-item .error.notice').remove();
		}

		// FORM SUBMISSION
		$el.closest('form').submit( function(event){

			clearValidationErrors();

			if( !validateForm() ){
				event.preventDefault();
				$form_alert.addClass("error notice").html("<p>There are some errors.</p>").show();
			}
		} );

	});

};


jQuery(document).on( 'ready', function(){
	jQuery('[data-behaviour~=klhpc-repeater]').klhpc_repeater();
});
