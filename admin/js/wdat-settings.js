/**
 * Contains the WDAT Settings logic
 *
 * @summary		Contains WDAT Settings logic
 *
 * @since			1.0.0
 * @requires	jQuery, jQuery-ui, underscore
 */


/**
 * This object contains all function to handle the behaviour.
 *
 * @namespace wdat
 *
 * @type {Object}
 */
var wdat = window.wdat || {};

(function( $ ) {

	var $list,
			$attrs,
			itemTple,
			isSortable = false;


	var addItem = function( event ) {
		event.preventDefault();

		var $selected = $attrs.filter(':selected');

		if ( !$selected.prop('disabled') ) {
			$list.append( itemTple({name: $selected.val(), label: $selected.text() }) );

			$selected.prop( 'disabled', 'disabled' );
			$selected.siblings(':not(:disabled)').eq(0).prop('selected', true);

			setSortable();
		}
	};

	var removeItem = function( event ) {
		event.preventDefault();

		$attrs.filter('[value="'+ this.previousElementSibling.value +'"]').prop('disabled', false);
		event.delegateTarget.removeChild( this.parentNode );
	};

	var init = function() {

		$list			= $('#wdat_attr_list');
		$attrs		= $('#wdat_attrs').children();
		itemTple	= _.template( $('#tmpl-wdat').html() );

		$list.on('click', '.wdat-remove-attribute', removeItem );
		$('#wdat_add_attr').on( 'click', addItem );

		setSortable();
	};

	var setSortable = function() {

		if ( !isSortable && 1 < $list.children().length ) {
			isSortable = true;

			$list.sortable({
				axis								: 'y',
				cursor							: 'move',
				opacity							: 0.65,
				placeholder					: 'wdat-sortable-placeholder',
				forceHelperSize			: false,
				forcePlaceholderSize: true,
				start: function(e, ui){
					ui.placeholder.height(ui.item.height());
				}
			});
			$list.disableSelection();
		}
	};

	$(document).ready(function() {
		init();
	});

})( jQuery );
