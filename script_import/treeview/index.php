<?php 
include('header.php');
?>
<title>tsree</title>
<link rel="stylesheet" href="jstree/style.min.css" />
<script src="jstree/jstree.min.js"></script>
<?php include('container.php');?>
<div class="container">
	<div class="row">	
		<div id="tree-data-container"></div>				
	</div>	
	
</div>
<script type="text/javascript">
$(document).ready(function(){ 
	var data = {};
	data['jobid'] 	= 1;
	data['pui'] 	= '_pui 2005448762';
	data['orderid']	= 39002566;
	data['userid']	= 1;

     $('#tree-data-container').jstree({
		'plugins': ["wholerow"],
        'core' : {
            'data' : {
				"data": data,
				"method": 'post',
                "url" : "tree_data.php",
                "dataType" : "json" 
            }
        }
    }) 
});
</script>
<?php include('footer.php');?>

