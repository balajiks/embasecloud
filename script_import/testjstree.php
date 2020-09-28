
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title></title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="//code.jquery.com/jquery-1.10.1.js"></script>


<script type="text/javascript" src="http://static.jstree.com/3.0.0-beta3/assets/dist/jstree.min.js"></script>
      <link rel="stylesheet" type="text/css" href="http://static.jstree.com/3.0.0-beta3/assets/dist/themes/default/style.min.css">
<script>
$(function () {
    $("#tree").jstree({
        "checkbox": {
            "keep_selected_style": false
        },
            "plugins": ["checkbox"]
    });
    $("#tree").bind("changed.jstree",
    function (e, data) {
        alert("Checked: " + data.node.id);
        alert("Parent: " + data.node.parent); 
        //alert(JSON.stringify(data));
    });
});
</script>
  
</head>
<body>
  Resources
<div id="tree">
    <ul>
        <li id="folder_1">Folder 1
            <ul>
                <li id="child_1">Child 1</li>
                <li id="child_2">Child 2</li>
            </ul>
        </li>
        <li id="folder_2">Folder 2</li>
    </ul>
</div>



</body>
</html>
