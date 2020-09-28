<?php $__env->startSection('content'); ?>
<input type="hidden" class="form-control" placeholder="jobid" name="jobid" id="jobid" value="<?php echo e($jobsourceinfo[0]->id); ?>" />
<input type="hidden" class="form-control" placeholder="pui" name="pui" id="pui" value="<?php echo e($jobsourceinfo[0]->pui); ?>" />
<input type="hidden" class="form-control" placeholder="orderid" name="orderid" id="orderid" value="<?php echo e($jobsourceinfo[0]->orderid); ?>" />
<section id="content">
  <section class="hbox stretch">
    <section class="vbox">
      <section class="scrollable wrapper bg">
        <section class="panel panel-default">
          <header class="panel-heading"> <?php echo e(svg_image('solid/cogs')); ?> <?php echo trans('app.'.'searchemtree'); ?> </header>
          <div class="panel-body">
            <div class="row">
              <div class="form-group">
                <div class="col-lg-12">
                  <div class="frmSearch">
                    <input type="text" id="txtemtreeterm" class="form-control" placeholder="<?php echo trans('app.'.'searchemtree'); ?>" name="txtemtreeterm" autocomplete="off">
                    <div id="suggesstion-box"></div>
                    <button type="submit" id="findtermbtn" class="btn btn-sm btn-<?php echo e(get_option('theme_color')); ?> m-xs pull-right" value="find-term"> <span class=""><?php echo e(svg_image('solid/envelope-open')); ?> Find Term</span> </button>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div id="preloader"><i class="fas fa-spin fa-spinner"></i> Loading...</div>
                  <div id="jstree-box-tree"></div>
				  
                </div>
              </div>
            </div>
          </div>
        </section>
      </section>
    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
<?php $__env->startPush('pagestyle'); ?>
<style>
.frmSearch {border: 1px solid #a8d4b1;margin: 2px 0px;border-radius:4px;}
/*#termList{float:left;list-style:none;width:50%;padding:0; position: absolute; z-index:1;}
#termList li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#termList li:hover{background:#e9711c;cursor: pointer; color:#FFFFFF !important;}
#search-box{padding: 5px;border: #a8d4b1 1px solid;border-radius:4px;}*/



#termList {
  float:left;list-style:none;width:50%;padding:0; position: absolute; z-index:1;
  -webkit-user-select: text;
  -ms-user-select: text;
  user-select: text; }
  #termList li {
    background: #f0f0f0;
    position: relative;
    padding: 10px 10px 10px 34px;
    border-bottom: 1px solid #ddd;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    cursor: pointer; }
    #termList li:hover {
      background: #002664;
      color: white; }
      #termList li:hover .prefTerm {
        color: white; }
      #termList li:hover div {
        color: #ddd; }
      #termList li:hover .emtreeIcon {
        border-color: white; }
        #termList li:hover .emtreeIcon span {
          background: white; }
    #termList li div {
     float:left;
	 padding:0px 10px 0px 0px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      color: #888; }
    #termList li .prefTerm {
      color: #505050; }
	  
	  
.emtreeIcon {
  position: absolute;
  top: 20px;
  left: 10px;
  width: 6px;
  height: 6px;
  padding: 2px;
  border: 2px solid #e9711c;
  border-radius: 50%; }
  .emtreeIcon span {
    display: block;
    width: 6px;
    height: 6px;
    background: #e9711c;
    border-radius: 50%; }
</style>
<link rel=stylesheet href="<?php echo e(getAsset('plugins/nestable/nestable.css')); ?>">
<?php echo $__env->make('stacks.css.form', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopPush(); ?> 
 <?php $__env->startPush('pagescript'); ?>
<script>
$("#preloader").hide();	


$('#txtemtreeterm').keyup(function(){
   var keyvalue = $(this).val();  
   if(keyvalue !='') {
   $("#preloader").show();	
		axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/termemtree', {
			searchterm: keyvalue
		})
		.then(function (response) {
			$('#suggesstion-box').fadeIn();  
			$('#suggesstion-box').html(response.data); 
			<!--toastr.success(response.data.message, '<?php echo trans('app.'.'success'); ?> ');-->
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

function selectedTerms(name,term){
	$("#txtemtreeterm").val(name);
	$("#suggesstion-box").hide();
	 $("#preloader").show();	
		axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/callapiemtree', {
			selectterm: name
		})
		.then(function (response) {

		$('#jstree-box-tree').jstree("destroy").empty();
		$('#jstree-box-tree').html(response.data.message); 
		open = false;
		toggle(open);
	$('#jstree-box-tree').jstree({
	  "core" : {
		"themes" : {
		  "variant" : "medium"
		}
	  },
	  "checkbox" : {
		"keep_selected_style" : false
	  },
	  "plugins" : [ "contextmenu" ],
	  "contextmenu":{         
			"items": function($node) {
				var tree = $("#jstree-box-tree").jstree(true);
				return {
					"Create": {
						"separator_before": false,
						"separator_after": false,
						"label": "Add Major",
						"action": function (obj) {
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
										
										console.log(response);
										toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
										$(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
										tag[0].reset();
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
					},
					"Rename": {
						"separator_before": false,
						"separator_after": false,
						"label": "Add Minor",
						"action": function (obj) { 
							var data = {};
								data['jobid'] 	= $('#jobid').val();
								data['pui'] 	= $('#pui').val();
								data['orderid']	= $('#orderid').val();
								data['termtype']= $($node.text).children('div').html();
								data['term']	= $($node.text).children('span').html();
								data['type']	= 'minor';
								data['term_added']		= 'esv';
							axios.post('<?php echo e(route('indexing.api.saveesvdata')); ?>', data)
								.then(function (response) {
										alert(response.data.message);
										return false;				
										
										console.log(response);
										toastr.success( response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
										$(".formSaving").html('<i class="fas fa-save"></i> <?php echo trans('app.'.'save'); ?> </span>');
										tag[0].reset();
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
		}
	}).bind("loaded	.jstree",
    function (e, data) {
        alert("Checked: " + data.node.id);
        alert("Parent: " + data.node.parent); 
        alert(JSON.stringify(data));
    });
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
	toggle(open);
		$("#preloader").hide();
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
function passsentences(selectedval,term,termType,score){
   if(selectedval !='') {
		$("#preloader").show();	
		axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/esvsentences', {
			selectterm: selectedval,
			term: term,
			termType: termType,
			score: score
		})
		.then(function (response) {
			$('#sentencesfeeds').html(response.data.message); 
			$("#preloader").hide();	
			<!--toastr.success(response.data.message, '<?php echo trans('app.'.'success'); ?> ');-->
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
}


jQuery(window).on('load', function() {
	var open = false;
	toggle(open);
});

function toggle(open){
   if(open){
    $("#jstree-box-tree").jstree('close_all');
    open = false;
   } else{
    $("#jstree-box-tree").jstree('open_all');
    open = true;
   }
}

$( "#findtermbtn" ).click(function() {
	var searchterm = $("#txtemtreeterm").val();
	
	
	if(searchterm !='') {
		$("#preloader").show();	
		axios.post('<?php echo e(get_option('site_url')); ?>api/v1/indexing/ajax/emtreefindterm', {
			selectterm: searchterm
		})
		.then(function (response) {
			
			$("#suggesstion-box").hide();	
			$("#termList").hide();	
			$("#preloader").hide();	
			$('#jstree-box-tree').html(response.data.message); 
			<!--toastr.success(response.data.message, '<?php echo trans('app.'.'success'); ?> ');-->
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.indexersourceapp', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>