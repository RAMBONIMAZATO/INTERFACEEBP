<!doctype html>
<html lang="en">
    <head>  
        <title>UPDATE</title>
        <!-- <script src="jquery.min.js"></script> -->
        
       <!--  <link rel="stylesheet" href="bootstrap.min.css" />  
        <script src="bootstrap.min.js"></script>   -->

            <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/vector-map/jqvmap.css">
    <link rel="stylesheet" href="../assets/vendor/jvectormap/jquery-jvectormap-2.0.2.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <!-- css datatable-->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/buttons.dataTables.min.css">
    <title>UPDATE</title>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/select.bootstrap4.css"/>
          
    </head>  
    <body>  
 	<div class="dashboard-main-wrapper">

	 	<?php include('../config/template/header.php'); ?>

	        <div class="row">
	        	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	                <div class="card"> 
					    <div class="table-responsive">  
						    <form method="post" id="update_form">
						    	<div class="card-header">
						        <div align="left"><input type="submit" name="multiple_update" id="multiple_update" class="btn btn-info" value="Multiple Update" /></div>
						        </div>
								<div class="card-body">
						            <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
						                <thead>
						                    <th><input type="checkbox" name="select-all" id="select-all"></th>
						                    <th>Name</th>
						                    <th>Address</th>
						                    <th>Gender</th>
						                    <th>Designation</th>
						                    <th>Age</th>
						                </thead>
						                <tbody></tbody>
						            </table>
								</div>	 
						    </form>
						</div>
					</div>  
	  			</div>
	  		</div>
		<?php include('../config/template/footer.php'); ?>
	</div>
	<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>

	<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
	<!-- slimscroll js-->
	<script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
	<!-- chartjs js-->
	<script src="../assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
	<script src="../assets/vendor/charts/charts-bundle/chartjs.js"></script>
	<!-- main js-->
	<script src="../assets/libs/js/main-js.js"></script>
	<!-- jvactormap js-->
	<script src="../assets/vendor/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="../assets/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<!-- sparkline js-->
	<script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
	<script src="../assets/vendor/charts/sparkline/spark-js.js"></script>
	 <!-- dashboard sales js-->
	<script src="../assets/libs/js/dashboard-sales.js"></script>
	<!-- Javascript datatable-->
	<script type="text/javascript" src="../assets/vendor/datatables/js/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
	<!-- Print data -->
	<script type="text/javascript" src="../assets/vendor/datatables/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="../assets/vendor/datatables/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="../assets/vendor/datatables/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="../assets/vendor/datatables/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="../assets/vendor/datatables/js/jszip.min.js"></script>
	<script type="text/javascript" src="../assets/vendor/datatables/js/datatables.min.js"></script>
	<script type="text/javascript" src="../assets/vendor/datatables/js/pdfmake.min.js"></script>
	<script type="text/javascript" src="../assets/vendor/datatables/js/vfs_fonts.js"></script>
	<script type="text/javascript" src="../assets/vendor/popper/popper.min.js"></script>
	<!--  print data-->
	<script type="text/javascript" language="javascript">

	    $(document).ready(function() {
	        $('#table_data').DataTable({
	            dom: 'lBfrtip',
	            buttons: [
	                'excel', 'csv', 'pdf', 'copy', 'print'
	            ],
	            "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]]
	        });
	    });

	</script>
    </body>  
</html>  
<script>  
$(document).ready(function(){  
    
    function fetch_data()
    {
        $.ajax({
            url:"select.php",
            method:"POST",
            dataType:"json",
            success:function(data)
            {
                var html = '';
                for(var count = 0; count < data.length; count++)
                {
                    html += '<tr>';
                    html += 
                    '<td><input type="checkbox" id="'+data[count].id+'" data-name="'+data[count].name+'" data-address="'+data[count].address+'" data-gender="'+data[count].gender+'" data-designation="'+data[count].designation+'" data-age="'+data[count].age+'" class="check_box"  /></td>';
                    html += '<td>'+data[count].name+'</td>';
                    html += '<td>'+data[count].address+'</td>';
                    html += '<td>'+data[count].gender+'</td>';
                    html += '<td>'+data[count].designation+'</td>';
                    html += '<td>'+data[count].age+'</td></tr>';
                }
                $('tbody').html(html);
            }
        });


    }

    fetch_data();

    $(document).on('click', '.check_box', function(){
        var html = '';
        if(this.checked){
            html = 
            '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-name="'+$(this).data('name')+'" data-address="'+$(this).data('address')+'" data-gender="'+$(this).data('gender')+'" data-designation="'+$(this).data('designation')+'" data-age="'+$(this).data('age')+'" class="check_box" checked /></td>';
            html += 
            '<td><input type="text" name="name[]" class="form-control" value="'+$(this).data("name")+'" /></td>';
            html += 
            '<td><input type="text" name="address[]" class="form-control" value="'+$(this).data("address")+'" /></td>';
            html += 
            '<td><select name="gender[]" id="gender_'+$(this).attr('id')+'" class="form-control"><option value="Male">Male</option><option value="Female">Female</option></select></td>';
            html += 
            '<td><input type="text" name="designation[]" class="form-control" value="'+$(this).data("designation")+'" /></td>';
            html += 
            '<td><input type="text" name="age[]" class="form-control" value="'+$(this).data("age")+'" /><input type="hidden" name="hidden_id[]" value="'+$(this).attr('id')+'" /></td>';
        }else{
            html = 
            '<td><input type="checkbox" id="'+$(this).attr('id')+'" data-name="'+$(this).data('name')+'" data-address="'+$(this).data('address')+'" data-gender="'+$(this).data('gender')+'" data-designation="'+$(this).data('designation')+'" data-age="'+$(this).data('age')+'" class="check_box" /></td>';
            html += '<td>'+$(this).data('name')+'</td>';
            html += '<td>'+$(this).data('address')+'</td>';
            html += '<td>'+$(this).data('gender')+'</td>';
            html += '<td>'+$(this).data('designation')+'</td>';
            html += '<td>'+$(this).data('age')+'</td>';            
        }
        $(this).closest('tr').html(html);
        $('#gender_'+$(this).attr('id')+'').val($(this).data('gender'));
    });

    $('#update_form').on('submit', function(event){
        event.preventDefault();
        if($('.check_box:checked').length > 0)
        {
            $.ajax({
                url:"multiple_update.php",
                method:"POST",
                data:$(this).serialize(),
                success:function()
                {
                    alert('Data Updated');
                    fetch_data();
                }
            })
        }
    });
});  
</script>