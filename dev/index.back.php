<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css" />
	<script type="text/javascript" src="bootstrap.min.js"></script>
</head>
<body>
	<div>
		<h2></h2>
		<div class="table-responsive">
			<h2 align="center">INSERT DATA</h2>
			<table class="table table-bordered" id="crud_table">
				<tr>
					<th width="30%">name</th>
					<th width="10%">code</th>
					<th width="45%">desc</th>
					<th width="10%">price</th>
					<th width="5%"></th>
				</tr>
				<tr>
					<td contenteditable="true" class="item_name"></td>
					<td contenteditable="true" class="item_code"></td>
					<td contenteditable="true" class="item_desc"></td>
					<td contenteditable="true" class="item_price"></td>
					<td></td>
				</tr>
			</table>
			<div align="right">
				<button type="button" name="add" id="add" class="btn btn-success btn-xs">+</button>
			</div><br/>
			<div align="center">
				<button type="button" name="save" id="save" class="btn btn-info">Save</button>
			</div>
			<br/>
			<div id="inserted_item_data">
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		var count = 1;
		$('#add').click(function(){
			count = count + 1 ;
			var html_code = "<tr id= 'row"+count+"'>";
			html_code += "<td contenteditable='true' class='item_name'></td>";
			html_code += "<td contenteditable='true' class='item_code'></td>";
			html_code += "<td contenteditable='true' class='item_desc'> </td>";
			html_code += "<td contenteditable='true' class='item_price'></td>";
			html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";
			html_code += "</tr>";
			$('#crud_table').append(html_code);
		});
		$(document).on('click', '.remove', function(){
			var delete_row = $(this).data("row");
			$('#' + delete_row).remove();
		});
		$('#save').click(function(){
			var item_name = [];
			var item_code = [];
			var item_desc = [];
			var item_price = [];

			$('.item_name').each(function(){
				item_name.push($(this).text());
			});
			$('.item_code').each(function(){
				item_code.push($(this).text());
			});
			$('.item_desc').each(function(){
				item_desc.push($(this).text());
			});
			$('.item_price').each(function(){
				item_price.push($(this).text());
			});
			$.ajax({
				url:"insert.php",
				method: "POST",
				data:{item_name:item_name, item_code:item_code, item_desc:item_desc, item_price:item_price},
				success:function(data){
					$("td[contentEditable='true']").text("");
					for(var i=2; i<=count; i++){
						$('tr#'+i+'').remove();
					}
				}

			});
		});
	});
</script>