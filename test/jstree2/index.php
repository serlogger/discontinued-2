<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSTree test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <link rel="stylesheet" href="dist/themes/default/style.min.css" />
    <script src="dist/jstree.min.js"></script>
</head>
<body>
    <div id="treeContainer"></div>
    <button>Jee</button>
    <script type="text/javascript">
    $(document).ready(function(){ 
        //fill data to tree  with AJAX call
        $('#treeContainer').jstree({
        'plugins': ["wholerow", "checkbox"],
            'core' : {
                'data' : {
                    "url" : "response.php",
                    "plugins" : [ "wholerow", "checkbox" ],
                    "dataType" : "json" // needed only if you do not supply JSON headers
                }
            }
        }) 
    });

$('#treeContainer').on("changed.jstree", function (e, data) {
  console.log(data.selected);
});

$('button').on('click', function () {
  $('#treeContainer').jstree('select_node', '2');
//   $('#treeContainer').jstree(true).select_node('2');
//   $.jstree.reference('#jstree').select_node('child_node_1');
});
    </script>
</body>
</html>