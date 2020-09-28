<?php /*?><script>
    $('.ajaxifyForm').submit(function (event) {
        $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
        event.preventDefault();
        var data = new FormData(this);
        axios.post($(this).attr("action"), data)
            .then(function (response) {
					if(response.data.success == true){
						$('#indexer_section').val(null).trigger('change');
						$("#indexer_section").select2({
        						maximumSelectionLength: @langapp('sectioncnt') - response.data.count
    					});
						toastr.success(response.data.message, '@langapp('response_status') ');
						$("#sectioncount").val(response.data.count);
						if(response.data.count == @langapp('sectioncnt')){
							$("#frmindexsectionshow").addClass("disabled");
							$("#frmindexsectionshow").attr("disabled", "disabled");	
						} else {
							$("#frmindexsectionshow").removeClass("disabled");
							$("#frmindexsectionshow").removeAttr("disabled");
							$("#indexer_section").focus();
						}
						
						$(".formSaving").html('<i class="fas fa-check"></i> @langapp('save') </span>');
					} else {
						toastr.error(response.data.message, '@langapp('response_status') ');
						$(".formSaving").html('<i class="fas fa-sync"></i> @langapp('try_again')</span>');

					}
                   
          })
          .catch(function (error) {
            if(error.response.data.exception){
                toastr.error('@langapp('request_failed')' , '@langapp('response_status') ');
                $(".formSaving").html('<i class="fas fa-sync"></i> @langapp('try_again')</span>');
            }else{
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; 
                });
                toastr.error( errorsHtml , '@langapp('response_status') ');
                $(".formSaving").html('<i class="fas fa-sync"></i> @langapp('try_again')</span>');
            }
            
            
        }); 
        
    });
</script><?php */?>
