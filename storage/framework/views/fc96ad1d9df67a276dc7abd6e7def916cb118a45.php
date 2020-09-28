<?php $__env->startPush('pagescript'); ?>
	<script>
	ajaxdatview();	
/*-----------------------------------------------------------------------------------------------------------*/
/*----------------------------------Field Section Indexing --------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
        $('#createSection').on('submit', function(e) {
            $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            e.preventDefault();
            var indexersection, data;
            indexersection = $(this);
            data = indexersection.serialize();
            axios.post('<?php echo e(route('indexing.api.savesection')); ?>', data)
            .then(function (response) {
					if(response.data.success == true){
						var maxselect = <?php echo trans('app.'.'sectioncnt'); ?> - response.data.count;
						$("#indexer_section").select2({
							maximumSelectionLength: maxselect
						});
						$('#indexer_section').val();
						if(response.data.count == <?php echo trans('app.'.'sectioncnt'); ?>){
							$("#indexer_section").addClass("disabled");
							$("#indexer_section").attr("disabled", "disabled");	
							$("#classification").addClass("disabled");
							$("#classification").attr("disabled", "disabled");	
							$("#Selpublication").addClass("disabled");
							$("#Selpublication").attr("disabled", "disabled");	
						} else {
							$("#indexer_section").val();
							$("#indexer_section").removeClass("disabled");
							$("#indexer_section").removeAttr("disabled");
							$("#indexer_section").focus();
							$("#Selpublication").removeClass("disabled");
							$("#Selpublication").removeAttr("disabled");
							$("#classification").removeClass("disabled");
							$("#classification").removeAttr("disabled");
						}
						$('.section-todo-list').prepend(response.data.html);
						$("#sectioncount").val(response.data.count);
						$("#pubchoicecount").val(response.data.pubchoicecount);
						$("#indexersectioncount").html(response.data.count);
                    	toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
						ajaxdatview();
						open = false;
						toggle(open);
						$(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
						$('#classification').val(null).trigger('change');
						$('#indexer_section').val(null).trigger('change');
						$('#Selpublication').val(null).trigger('change');
					} else {
						$("#indexer_section").removeClass("disabled");
						$("#indexer_section").removeAttr("disabled");
						$("#indexer_section").focus();
						toastr.error( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
					}
                    $(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
					
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
               		errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
                $(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
        	});
        });
		
		
		
	$('.section-list').on('click', '.editSection', function (e) {
		e.preventDefault();
		var section, id;
		section = $(this);
		id = section.data('section-id');
		axios.get('<?php echo e(get_option("site_url")); ?>api/v1/indexing/getsectiondata/'+id, {
          "id": id
        })
		.then(function (response) {
			$('#sectionid').val(response.data[0].id);
			$("#indexer_section").select2().val(response.data[0].sectionval).trigger("change");
			$("#Selpublication").select2().val(response.data[0].pubchoice).trigger("change");
			$('#Selpublication').val(response.data[0].pubchoice);
			$('#updateclassification').val(response.data[0].classificationval);
		})
		.catch(function (error) {
			var errors = error.response.data.errors;
			var errorsHtml= '';
			$.each( errors, function( key, value ) {
				errorsHtml += '<li>' + value[0] + '</li>';
			});
			toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
			$(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
		});
	});

	$('.section-list').on('click', '.deleteSection', function (e) {
            e.preventDefault();
            var section, id;
            section = $(this);
            id = section.data('section-id');
            if(!confirm('Do you want to delete this '+ $('#section-'+id+' .widget-heading').html() +' data?')) {
                return false;
            }
			$("#preloader").show();
			$("#indexer_section").select2("destroy").select2();
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/sectionindex', {
               id: id,
            })
            .then(function (response) {
				var sectioncnt = $('#sectioncount').val() -1;
				$("#sectioncount").val(response.data.count);
				$("#pubchoicecount").val(response.data.pubchoicecount);
				$("#indexersectioncount").html(response.data.count);
				$('#indexersectioncount').val(response.data.count);
				$("#indexer_section").select2({
					maximumSelectionLength: <?php echo trans('app.'.'sectioncnt'); ?> - 1
				});
				$('#indexer_section').val();	
				if(response.data.count == <?php echo trans('app.'.'sectioncnt'); ?>){
					$("#indexer_section").addClass("disabled");
					$("#indexer_section").attr("disabled", "disabled");	
					$("#classification").addClass("disabled");
					$("#classification").attr("disabled", "disabled");	
					$("#Selpublication").addClass("disabled");
					$("#Selpublication").attr("disabled", "disabled");	
				} else {
					$("#indexer_section").removeClass("disabled");
					$("#indexer_section").removeAttr("disabled");
					$("#indexer_section").focus();
					$("#Selpublication").removeClass("disabled");
					$("#Selpublication").removeAttr("disabled");
					$("#classification").removeClass("disabled");
					$("#classification").removeAttr("disabled");
				}
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				$("#preloaderloading").show();
				$('#sectiondata-' + id).hide(500, function () {
					$(this).remove();
				});
				$(".innerhtmlclassification").html();	
				$('.innerhtmlclassification').hide(1000, function () {
				   $(".innerhtmlclassification").html();	
				});
				$("#preloaderloading").hide();
				$("#preloader").hide();
				ajaxdatview();
				var open = false;
				toggle(open);
				$("#preloader").hide();
				$('#indexer_section').val(null).trigger('change');
            })
 });
		
/*----------------------------------Delete Section Classification Indexing --------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
		
	function deleteClassification(classval,id){
		if(!confirm('Do you want to delete this "'+classval+'" classification message?')) {
			return false;
		}
		$("#preloaderloading").show();
		axios.post('<?php echo e(get_option("site_url")); ?>api/v1/indexing/deleteclassification', {
			id: id,
			data: classval,
		})
		.then(function (response) {
				$('.innerhtmlclassification').html(response.data.html);		
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				ajaxdatview();
				var open = false;
				toggle(open);
				$("#preloaderloading").hide();
		})
		.catch(function (error) {
			toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
		});
		$("#preloader").hide();
	
	}
	
	$('.section-list').on('click', '.sectionajax', function (e) {
		e.preventDefault();
		$("#preloader").hide();
		$( ".card" ).removeClass( "active" );
		var sectionlistId = $(this).attr("data-id");
		$( "#section-"+$(this).attr("data-id") ).parents().addClass( "active" );
		$('.innerhtmlclassification').html('<i class="fas fa-spin fa-spinner"></i> Loading...');
		if(sectionlistId !='') {
			axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/getclassificationdetails', {
				id: sectionlistId
			})
			.then(function (response) {
				$("#preloader").hide();
				$('.innerhtmlclassification').html(response.data.html);	
			})
			.catch(function (error) {
				var errors = error.response.data.errors;
				var errorsHtml= '';
				$.each( errors, function( key, value ) {
					errorsHtml += '<li>' + value[0] + '</li>';
				});
				toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
			});
		}
	 });
		
/*-----------------------------------------------------------------------------------------------------------*/
/*----------------------------------Field Section Medical --------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/		
		
		$('#createMedical').on('submit', function(e) {
			if(($("#txtmedicalterm").val() !='') || ($("input[name='hide_mmtct']").is(":checked") == true)){
				$(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
				e.preventDefault();
				var indexermedical, data;
				indexermedical = $(this);
				var medical_checktags = [];  
				$('.mmtctselectdata').each(function(){  
					if($(this).is(":checked")) {  
						medical_checktags.push($(this).val());  
					}  
				});  
		   		data = data +medical_checktags;
		   		data = indexermedical.serialize();
				axios.post('<?php echo e(route('indexing.api.savemedical')); ?>', data)
				.then(function (response) {
					if(response.data.success == true){
						if(response.data.recordstatus == 'update'){						
							$('#medicaldata-'+ $("#medicalid").val()).hide(500, function () {
                        		$(this).remove();
                   			});	
						}
						
						
						ajaxdatview();
						open = false;
						toggle(open);
						$("#txtmedicalterm").val('');
						$('#indexer_diseaseslink').val(null).trigger('change');
						$("#txtmedicalmajor").prop("checked", false);
						$("#txtmedicalminor").prop("checked", false);
						$("#hide_mmtct").val("FALSE");
						$('#dieseasesenablelink').addClass("disabledbutton");
						$('#txtmedicalterm').prop("disabled", true);
						
						
						if(response.data.type == '1' || response.data.type == '3' || response.data.type == '5') {
							$('#major-listdata').prepend(response.data.htmlmedicalterm);	
						} else {
							$('#minor-listdata').prepend(response.data.htmlmedicalterm);
						}
						$('#diseases-listdata').prepend(response.data.htmldiseases); 
						$('#checktags-listdata').prepend(response.data.htmlchecktag);
											
						$("#medchecktagtotalajax").html(response.data.checktagcount);
						$("#medminortotalajax").html(response.data.minorcount);
						$("#medmajortotalajax").html(response.data.majorcount);					
						$("#medtotalajax").html(response.data.totalmedcountterm);					
						$("#meddiseasestotalajax").html(response.data.diseasescount);					
						toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
						$(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
						indexermedical[0].reset();	
						
						
						
						
										
					} else {
						toastr.error( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');	
						$(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');			
					}
				})
				.catch(function (error) {
				
					var errors = error.response.data.errors;
					var errorsHtml= '';
					$.each( errors, function( key, value ) {
						errorsHtml += '<li>' + value[0] + '</li>';
					});
					toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
					$(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
				});
  		} else {
			alert('Please enter medical term !!');
			return false;
		}
	});
		
		
		$('#major-mediallistdata').on('click', '.deletemedicalterm', function (e) {
            e.preventDefault();
            var medical, id;
            medical = $(this);
            id 		= 	medical.data('medical-id');
            if(!confirm('Do you want to delete this "'+ $('#medical-'+id+' .widget-heading').html() +'" indexing term ?')) {
                return false;
            }
			axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/medicaltermindex', {
               id: id,
            })
            .then(function (response) {
					$("#medchecktagtotalajax").html(response.data.checktagcount);
					$("#medminortotalajax").html(response.data.minorcount);
					$("#medmajortotalajax").html(response.data.majorcount);					
					$("#medtotalajax").html(response.data.totalmedcountterm);					
					<!--$("#meddiseasestotalajax").html(response.data.diseasescount);-->
					$('#medicaldata-' + id).hide(500, function () {
                        $(this).remove();
                    });	
					$('#termsdiseasesdata-' + id).hide(500, function () {
                        $(this).remove();
                    });
					ajaxdatview();
					open = false;
					toggle(open);
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
       		 });
        });
		
		
		$('#minor-mediallistdata').on('click', '.deletemedicalterm', function (e) {
            e.preventDefault();
            var medical, id;
            medical = $(this);
            id 		= 	medical.data('medical-id');
            if(!confirm('Do you want to delete this "'+ $('#medical-'+id+' .widget-heading').html() +'" indexing term ?')) {
                return false;
            }
			axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/medicaltermindex', {
               id: id,
            })
            .then(function (response) {
					$("#medchecktagtotalajax").html(response.data.checktagcount);
					$("#medminortotalajax").html(response.data.minorcount);
					$("#medmajortotalajax").html(response.data.majorcount);					
					$("#medtotalajax").html(response.data.totalmedcountterm);					
					<!--$("#meddiseasestotalajax").html(response.data.diseasescount);-->
					$('#medicaldata-' + id).hide(500, function () {
                        $(this).remove();
                    });	
					$('#termsdiseasesdata-' + id).hide(500, function () {
                        $(this).remove();
                    });
					ajaxdatview();
					open = false;
					toggle(open);
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
       		 });
        });
		
		
		
		
		
		$('#diseases-listdata').on('click', '.deletemedicalterm', function (e) {
            e.preventDefault();
            var medical, id;

            medical = $(this);
            id 		= 	medical.data('section-id');
			jobid 	=  $('#jobid').val();
			orderid =  $('#orderid').val();

            if(!confirm('Do you want to delete this message?')) {
                return false;
            }
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/'+jobid+'/'+orderid+'/medicaltermindex', {
                    id: id,
					jobid: jobid,
					orderid: orderid,
            })
            .then(function (response) {
			
					$("#medchecktagtotalajax").html(response.data.checktagcount);
					$("#medminortotalajax").html(response.data.minorcount);
					$("#medmajortotalajax").html(response.data.majorcount);					
					$("#medtotalajax").html(response.data.totalmedcountterm);					
					$("#meddiseasestotalajax").html(response.data.diseasescount);
					
					$('#termsdiseasesdata-' + id).hide(500, function () {
                        $(this).remove();
                    });	
					
					$('#termsdata-' + id).hide(500, function () {
                        $(this).remove();
                    });
			
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
					ajaxdatview();
					open = false;
					toggle(open);
					
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });
		
		$('.medical-list').on('click', '.deletechecktag', function (e) {
            e.preventDefault();
            var checktags, id;

            checktags 	= 	$(this);
            id 			= 	checktags.data('checktag-id');
			jobid 		=  	$('#jobid').val();
			orderid 	=  	$('#orderid').val();
			
			if(!confirm('Do you want to delete this "'+ $('#checktag-'+id+' .widget-heading').html() +'" Check tags?')) {
                return false;
            }
			
			$("#preloader").show();
			axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/medicalchecktagtermindex', {
               id: id,
            })
            .then(function (response) {
					$("#medchecktagtotalajax").html(response.data.checktagscount);
					$('#medicalchecktagdata-'+ id).hide(500, function () {
                        $(this).remove();
                    });	
			
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
					ajaxdatview();
					open = false;
					toggle(open);
					
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });




$('.medical-list').on('click', '.editMedical', function (e) {
	e.preventDefault();
	var medical, id;
	medical = $(this);
	id = medical.data('medical-id');
	axios.get('<?php echo e(get_option("site_url")); ?>api/v1/indexing/getmedicaldata/'+id, {
	  "id": id
	})
	.then(function (response) {
		$('#medicalid').val(response.data[0].id);
		
		var termcategory = response.data[0].termcategory;
		switch (termcategory) {
		  case 'medicalterm':
			$("#txtmedical"+response.data[0].type). prop("checked", true);	
			break;
		  case 'diseaseterm':
			$("#txtmedicalcandidate"+response.data[0].type+"disease"). prop("checked", true);	
			break;
		  case 'candidateterm':
			$("#txtmedicalcandidate"+response.data[0].type). prop("checked", true);
			$('#updatediseases').val('0');
			
			break;
		}
		
		if(response.data[0].diseaseslink !='Null' || response.data[0].diseaseslink == ''){
			$('#updatediseases').val(response.data[0].diseaseslink);
			$('#indexer_diseaseslink').removeClass("disabledbutton");
			$("#indexer_diseaseslink").removeAttr("disabled");
			$('#dieseasesenablelink').removeClass("disabledbutton");
			$("#dieseasesenablelink").removeAttr("disabled");
			var updatedisease = response.data[0].diseaseslink;
			var res = updatedisease.split(",");
			$("#indexer_diseaseslink").select2().val(res).trigger("change");
			
		} else {
			$('#updatediseases').val('0');	
			$('#indexer_diseaseslink').addClass("disabledbutton");
			$("#indexer_diseaseslink").attr("disabled", "disabled");
			$('#dieseasesenablelink').addClass("disabledbutton");
			$("#dieseasesenablelink").attr("disabled");	
		}
		
		$("#txtmedicalterm").val(response.data[0].medicalterm);
		$("#txtmedicalterm").removeClass("disabled");
		$("#txtmedicalterm").removeAttr("disabled");
		$("#txtmedicalterm").focus();
		
		var maxselect = 8; 
		$("#indexer_diseaseslink").select2({
			placeholder: "Diseases Links",
			maximumSelectionLength: maxselect
		});
		
		$('#suggesstion-box').show();
		callautosuggestion('show');	
		
		
	})
	.catch(function (error) {
		var errors = error.response.data.errors;
		var errorsHtml= '';
		$.each( errors, function( key, value ) {
			errorsHtml += '<li>' + value[0] + '</li>';
		});
		toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
		$(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
	});
});		

/*-----------------------------------------------------------------------------------------------------------*/
/*----------------------------------Field Section Medical --------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/		

	$('#createDrug').on('submit', function(e) {
            $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            e.preventDefault();
            var indexerdrug, data;
            indexerdrug = $(this);
			
		    data = indexerdrug.serialize();
            axios.post('<?php echo e(route('indexing.api.savedrug')); ?>', data)
            .then(function (response) {
					<!--console.log(response);-->
					<!--return false;-->
					ajaxdatview();
					open = false;
					toggle(open);

					$("#txtdrugmedicalterm").val('');
					$("#txtdrugmajor").prop("checked", false);
					$("#txtdrugminor").prop("checked", false);
					
					if(response.data.type == '1') {
                    	$('#major-listdata').prepend(response.data.htmldrugterm);	
					} else {
						$('#minor-listdata').prepend(response.data.htmldrugterm);
					}
					 
									
					$("#drugminortotalajax").html(response.data.minorcount);
					$("#drugmajortotalajax").html(response.data.majorcount);
							
					$("#drugtotalajax").html(response.data.totaldrugcountterm);					
					
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                    $(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
                    indexerdrug[0].reset();
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
                $(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
        });
        });
		
		
		$('#createDrugLinks').on('submit', function(e) {
            $("#savebtn").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            e.preventDefault();
            var indexerdruglinks, data;
            indexerdruglinks = $(this);
			
		    data = indexerdruglinks.serialize();
            axios.post('<?php echo e(route('indexing.api.savedruglinks')); ?>', data)
            .then(function (response) {
					$("#tabcontent").empty().append(response.data.htmldrugterm);
					$("#preloader").hide();
					
					ajaxdatview();
					open = false;
					toggle(open);
					
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                    $("#savebtn").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
					 
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
                $("#savebtn").html('<i class="fas fa-sync"></i> Try Again');
        });
        });
		
		
		$('#createDrugTradeName').on('submit', function(e) {
            $("#savebtn").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            e.preventDefault();
            var indexerdruglinks, data;
            indexerdruglinks = $(this);
			
		    data = indexerdruglinks.serialize();
            axios.post('<?php echo e(route('indexing.api.savedrugtradename')); ?>', data)
            .then(function (response) {
					$('.drugtradename-list').prepend(response.data.htmldrugterm);
					if(response.data.action == 'update') {
						$('#termsdata-' + response.data.id).hide(500, function () {
							$(this).remove();
						});
						$('#ajaxtradename-listdata').hide(500, function () {
							$(this).remove();
						});
					}
				
					ajaxdatview();
					open = false;
					toggle(open);
	
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                    $("#savebtn").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
					indexerdruglinks[0].reset(); 
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
                $("#savebtn").html('<i class="fas fa-sync"></i> Try Again');
        });
        });
		
		
		$('.drugtradename-list').on('click', '.deletetradeterm', function (e) {
            e.preventDefault();
            var tradeterm, id;

            tradeterm = $(this);
            id = tradeterm.data('termsdata-id');
            if(!confirm('Do you want to delete this "'+$('#termsdata-'+id+' .widget-heading').html()+'" message?')) {
                return false;
            }
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/drugtrademanufacture', {
                    id: id,
            })
            .then(function (response) {
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				$('#ajaxtradename-listdata').hide(500, function () {
					$(this).remove();
				});
				$('#termsdata-' + id).hide(500, function () {
					$(this).remove();
				});
				$('ul#ajaxdrugtradename li').remove();
				
				ajaxdatview();
				open = false;
				toggle(open);
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });	
		
		
	
		$('#ajaxdrugtradename').on('click', '.deleteajaxtradelink', function (e) {
            e.preventDefault();
            var tradeterm, id, value;

            tradeterm = $(this);
            value = tradeterm.data('termsdata-id');
			id = $('#selectedmanuid').val();
			

            if(!confirm('Do you want to delete this "'+value+'" message?')) {
                return false;
            }
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/'+value+'/deletedrugtradename', {
                    id: id,
					value: value,
            })
            .then(function (response) {
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				$('#ajaxtradelink-'+value).hide(500, function () {
					$(this).remove();
				});
				ajaxdatview();
				open = false;
				toggle(open);
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });	
		
		$('.devicetradename-list').on('click', '.deletetradeterm', function (e) {
            e.preventDefault();
            var tradeterm, id;

            tradeterm = $(this);
            id = tradeterm.data('termsdata-id');
            if(!confirm('Do you want to delete this "'+$('#termsdata-'+id+' .widget-heading').html()+'" message?')) {
                return false;
            }
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/deletemedicaldevicetradename', {
                    id: id,
            })
            .then(function (response) {
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				
				$('#termsdata-' + id).hide(500, function () {
					$(this).remove();
				});
				$('ul#ajaxdevicetradename li').remove();
				
				ajaxdatview();
				open = false;
				toggle(open);
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });	


/*-----------------------------------------------------------------------------------------------------------*/
/*----------------------------------Field Device Trade Name--------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/		

		$('#createDeviceTradeName').on('submit', function(e) {
            $("#savebtn").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            e.preventDefault();
            var indexerdevicelinks, data;
            indexerdevicelinks = $(this);
			
		    data = indexerdevicelinks.serialize();
            axios.post('<?php echo e(route('indexing.api.savedevicetradename')); ?>', data)
            .then(function (response) {
				$('.devicetradename-list').prepend(response.data.htmldrugterm);
				if(response.data.action == 'update') {
					$('#termsdata-' + response.data.id).hide(500, function () {
						$(this).remove();
					});
					$('#ajaxtradename-listdata').hide(500, function () {
						$(this).remove();
					});
				}
				ajaxdatview();
				open = false;
				toggle(open);

				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				$("#savebtn").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
				indexerdevicelinks[0].reset(); 
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
                $("#savebtn").html('<i class="fas fa-sync"></i> Try Again');
        });
        });	
		
		$('#ajaxdevicetradename').on('click', '.deleteajaxtradelink', function (e) {
            e.preventDefault();
            var tradeterm, id, value;

            tradeterm = $(this);
            value = tradeterm.data('termsdata-id');
			id = $('#selectedmanuid').val();
			

            if(!confirm('Do you want to delete this "'+value+'" message?')) {
                return false;
            }
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/'+value+'/deletedevicetradename', {
                    id: id,
					value: value,
            })
            .then(function (response) {
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				$('#ajaxtradelink-' + value).hide(500, function () {
					$(this).remove();
				});
				ajaxdatview();
				open = false;
				toggle(open);
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });	
		
/*-----------------------------------------------------------------------------------------------------------*/
/*----------------------------------Field Section CTN --------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/		
	$('#createCtn').on('submit', function(e) {
            $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            e.preventDefault();
            var indexerctn, data;
            indexerctn = $(this);
			
		    data = indexerctn.serialize();
            axios.post('<?php echo e(route('indexing.api.savectn')); ?>', data)
            .then(function (response) {
				$('#trailnumberlist').prepend(response.data.htmlctnterm);	
				$('#registryname').val(null).trigger('change');			
				ajaxdatview();
				open = false;
				toggle(open);
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				$(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
				indexerctn[0].reset();
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
                $(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
        });
        });
	
	$('.ctn-list').on('click', '.deleteCtn', function (e) {
            e.preventDefault();
            var section, id;

            section = $(this);
            id = section.data('ctn-id');

            if(!confirm('Do you want to delete this message?')) {
                return false;
            }
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/drugctnindex', {
                    id: id,
            })
            .then(function (response) {
				toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
				$('#ctn-' + id).hide(500, function () {
					$(this).remove();
				});
				ajaxdatview();
				open = false;
				toggle(open);
				
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });	
	
	
	
	
	
/*-----------------------------------------------------------------------------------------------------------*/
/*----------------------------------Field Section CTN --------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/		
	
	$('#createMedicalIndexing').on('submit', function(e) {
            $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
            e.preventDefault();
            var indexerctn, data;
            indexerctn = $(this);
			
		    data = indexerctn.serialize();
            axios.post('<?php echo e(route('indexing.api.savemedicalindexing')); ?>', data)
            .then(function (response) {
					
					$("#txtdeviceterm").val('');
					$("#sublink").val('');
					$('#indexer_sublink').val(null).trigger('change');
					$("#txtmedicalmajor").prop("checked", false);
					$("#txtmedicalminor").prop("checked", false);
					
					$('#devicelink').addClass("disabledbutton");
					$('#txtdeviceterm').prop("disabled", true);
					
					if(response.data.type == '1') {
                    	$('#major-listdata').prepend(response.data.htmlmedicalterm);	
					} else {
						$('#minor-listdata').prepend(response.data.htmlmedicalterm);
					}
					 
					$('#sublink-listdata').prepend(response.data.htmldiseases); 
									
					$("#medminortotalajax").html(response.data.minorcount);
					$("#medmajortotalajax").html(response.data.majorcount);					
					$("#medtotalajax").html(response.data.totalmedcountterm);					
					$("#meddiseasestotalajax").html(response.data.diseasescount);				
					
					ajaxdatview();
					open = false;
					toggle(open);

                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                    $(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
                    indexerctn[0].reset();
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
                $(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
        });
        });
	
	
	
	
	$('#major-mediallistdata').on('click', '.deletemedicaldeviceterm', function (e) {
            e.preventDefault();
            var medical, id;

            medical = $(this);
            id 		= 	medical.data('section-id');
			jobid 	=  $('#jobid').val();
			orderid =  $('#orderid').val();

            if(!confirm('Do you want to delete this message?')) {
                return false;
            }
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/'+jobid+'/'+orderid+'/medicaldevicetermindex', {
                    id: id,
					jobid: jobid,
					orderid: orderid,
            })
            .then(function (response) {
			
					$("#medchecktagtotalajax").html(response.data.checktagcount);
					$("#medminortotalajax").html(response.data.minorcount);
					$("#medmajortotalajax").html(response.data.majorcount);					
					$("#medtotalajax").html(response.data.totalmedcountterm);					
					$("#meddiseasestotalajax").html(response.data.diseasescount);
					$('#termsdata-' + id).hide(500, function () {
                        $(this).remove();
                    });	
					
					$('#termsdiseasesdata-' + id).hide(500, function () {
                        $(this).remove();
                    });
			
					ajaxdatview();
					open = false;
					toggle(open);
			
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                    
					
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });
		
		$('#minor-mediallistdata').on('click', '.deletemedicaldeviceterm', function (e) {
            e.preventDefault();
            var medical, id;

            medical = $(this);
            id 		= 	medical.data('section-id');
			jobid 	=  $('#jobid').val();
			orderid =  $('#orderid').val();

            if(!confirm('Do you want to delete this message?')) {
                return false;
            }
            axios.delete('<?php echo e(get_option("site_url")); ?>api/v1/indexing/'+id+'/'+jobid+'/'+orderid+'/medicaldevicetermindex', {
                    id: id,
					jobid: jobid,
					orderid: orderid,
            })
            .then(function (response) {
			
					$("#medchecktagtotalajax").html(response.data.checktagcount);
					$("#medminortotalajax").html(response.data.minorcount);
					$("#medmajortotalajax").html(response.data.majorcount);					
					$("#medtotalajax").html(response.data.totalmedcountterm);					
					$("#meddiseasestotalajax").html(response.data.diseasescount);
					$('#termsdata-' + id).hide(500, function () {
                        $(this).remove();
                    });	
					
					$('#termsdiseasesdata-' + id).hide(500, function () {
                        $(this).remove();
                    });
					
					ajaxdatview();
					open = false;
					toggle(open);
			
                    toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                    
					
            })
            .catch(function (error) {
                toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
        });

        });
	
	
	
	
	
	
function ajaxdatview(){
	var data = {};
	data['jobid'] 	= $('#project_jobid').val();
	data['pui'] 	= $('#project_pui').val();
	data['orderid']	= $('#project_orderid').val();
	data['userid']	= '<?php echo Auth::id() ?>';
	
	var strpui 		= $('#project_pui').val();
	var pui			= strpui.replace("_pui ", "");
	var filepath 	= "<?php echo e(get_option('site_url')); ?>"+"datfileview/"+$('#project_jobid').val()+"_"+$('#project_orderid').val()+"_"+pui+".json";
	axios.post("<?php echo e(route('indexing.api.ajaxdatview')); ?>", {
		jobid: $('#project_jobid').val(),
		pui: $('#project_pui').val(),
		orderid: $('#project_orderid').val(),
		userid: '<?php echo Auth::id() ?>'
	})
	.then(function (response) {
	
	$('#tree-data-container').jstree("destroy").empty(); 
	
		$('#tree-data-container').jstree({
		"core" : {
			"themes" : {
			  "variant" : "medium"
			}
		  },
		'plugins': ["contextmenu"],
		"contextmenu":{         
			"items": function($node) {
				var tree = $("#tree-data-container").jstree(true);
				return {
				"Remove": {
					"separator_before": false,
					"separator_after": false,
					"label": "Remove",
					"action": function (obj) { 
						tree.jstree('delete_node', $node);
						return false;
						var data = {};
							data['jobid'] 	= $('#jobid').val();
							data['pui'] 	= $('#pui').val();
							data['orderid']	= $('#orderid').val();
							data['termtype']= $($node.text).children('div').html();
							data['term']	= $($node.text).children('span').html();
							data['type']	= 'major';
							data['term_added']		= 'esv';
						axios.post('<?php echo e(route('indexing.api.saveesvdata')); ?>', data)
							.then(function (response) {
									alert(response.data.message);
									return false;				
							})
							.catch(function (error) {
								var errors = error.response.data.errors;
								var errorsHtml= '';
								$.each( errors, function( key, value ) {
								errorsHtml += '<li>' + value[0] + '</li>';
								});
								toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
								$(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
						});
					}
				  }
				};
			}
		},
        'core' : {
            'data' : {
			    "url" : "<?php echo e(get_option('site_url')); ?>"+"datfileview/"+$('#project_jobid').val()+"_"+$('#project_orderid').val()+"_"+pui+".json",
                "dataType" : "json" 
				}
        	}
    	});
		
		var tree = $("#tree-data-container");
		tree.bind("loaded.jstree", function (event, data) {
			tree.jstree("open_all");
		});
	})
	.catch(function (error) {
		var errors = error.response.data.errors;
		var errorsHtml= '';
		$.each( errors, function( key, value ) {
		errorsHtml += '<li>' + value[0] + '</li>';
		});
		toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
	});
}	
	
	


function toggle(open){
	<!--alert('ada');-->
   if(open){
    $("#tree-data-container").jstree('close_all');
    open = false;
   } else{
    $("#tree-data-container").jstree('open_all');
    open = true;
   }
}	


 
 $('.todo-list-wrapper').on('click', '.medicalajax', function (e) {
	e.preventDefault();
	var medicallistId = $(this).attr("data-id");
	$('#diseaseterm').html('<i class="fas fa-spin fa-spinner"></i> Loading...');
	if(medicallistId !='') {
		axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/getmedicaldiseasesdetails', {
			id: medicallistId
		})
		.then(function (response) {
			$("#preloader").hide();
			$('#diseaseterm').html(response.data.html);			
		})
		.catch(function (error) {
			var errors = error.response.data.errors;
			var errorsHtml= '';
			$.each( errors, function( key, value ) {
				errorsHtml += '<li>' + value[0] + '</li>';
			});
			toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
		});
	}
 });	



function deleteDiseases(classval,id){
	if(!confirm('Do you want to delete this "'+classval+'" Diseases message?')) {
		return false;
	}
	axios.post('<?php echo e(get_option("site_url")); ?>api/v1/indexing/deletediseases', {
        id: id,
		data: classval,
    })
	.then(function (response) {
			$('#diseaseterm').html(response.data.html);		
			toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
			ajaxdatview();
			var open = false;
			toggle(open);
	})
	.catch(function (error) {
		toastr.error( 'Oops! Something went wrong!' , '<?php echo trans('app.'.'response_status'); ?> ');
});

}

$("#selectAll").click(function(){
    $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
});

		
	</script>
<?php $__env->stopPush(); ?>