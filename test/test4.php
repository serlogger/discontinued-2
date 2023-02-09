<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
</head>
<body>
	<div id="treeview"></div>
	<script>
		$('#treeview').jstree({
		'core': {
			'data': [{
				"id": "1",
				"parent": "#",
				"text": "Parent1"
			}, {
				"id": "2",
				"parent": 1,
				"text": "Child1"
			},
			{
				"id": "21",
				"parent": 2,
				"text": "Child1"
			},
			{
				"id": "3",
				"parent": 2,
				"text": "Child12"
			}, {
				"id": "4",
				"parent": 1,
				"text": "Child2"
			}, {
				"id": "5",
				"parent": 1,
				"text": "Child3"
			},
			{
				"id": "6",
				"parent": 4,
				"text": "Child21"
			},
			{
				"id": "7",
				"parent": '#',
				"text": "Parent 2"
			},
			{
				"id": "8",
				"parent": 7,
				"text": "Child"
			}
			]
		}
		});

		$('#treeview').on("select_node.jstree", function(e, data) {
			// var isParent = data.instance.is_parent(data);
			// If you need to check if a node is a root node you can use:
			var isParent = (data.node.children.length > 0);
			console.log(data.node);
			console.log(data.node.children);
			console.log(isParent)
		//for each node, check if is_parent. If yes, please disable it.
		});

	</script>
</body>
</html>