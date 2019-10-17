(function( $ ){

	var ajax = function( action, block_id ){

		var data = {
			action   : action,
			nonce    : CB_SETTINGS.ajax_nonce,
			block_id : block_id
		};

		$.ajax({
			url : CB_SETTINGS.ajax_url,
			type: "POST",
			data: data,
			success: function(result){
				// console.log( result );
		  	},
		  	beforeSend: function(){

		  	},
			complete : function(){

			}
		});
	}

	$( document ).ready( function(){
		$( document ).on( 'change', '.cb-toggler', function( e ){
			e.preventDefault();

			var block_id = $( this ).data( 'action' ),
			    val      = $( this ).prop( 'checked' ),
			    action = val ? 'activate_block' : 'deactivate_block';
			if( 'bulk' == block_id ){
				action = val ? 'bulk_activate_blocks' : 'bulk_deactivate_blocks';
			}

			ajax( action, block_id );

		});
	});
})( jQuery )