<!DOCTYPE html>
<html>
<head>
	<title></title>
    <!-- ajax selector -->
    <script>
        function showUser(str) {
          if (str=="") {
            document.getElementById("txtHint").innerHTML="";
            return;
          } 
          var xmlhttp=new XMLHttpRequest();
          xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
              document.getElementById("txtHint").innerHTML=this.responseText;
            }
          }
          xmlhttp.open("GET","get_user.php?q="+str,true);
          xmlhttp.send();
        }
    </script>
</head>
<body>

    <!-- <div class="row"> -->
        <!-- <form> -->
        <!-- <div> -->
        	<table>
        		<thead>
	        		<tr>
	        			<th>Choix departement</th>
	        			<th>Liste user</th>
	        		</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>
        					<form>
        					<select name="users" onchange="showUser(this.value)">
					            <option value="">Select a person:</option>
					            <option value="35">EXP</option>
					            <option value="42">STR</option>
					            <option value="34">GNR</option> 
					            <option value="30">ADM</option>
					        </select>
					        </form>
        				</td>
        				<td>
        					<div id="txtHint"></div>
        				</td>
        			</tr>
        		</tbody>
        		</table>
        	
           <!--  <?php  
                $q="SELECT DISTINCT Code FROM t_dept_user ORDER BY Code";
                $r_q=mysqli_query($connection, $q);
                while ($ligne = mysqli_fetch_array($r_q)) {
            ?>
            		<option value="<?php echo $ligne["Code"]; ?>"></option> -->
           <!--  <?php 
                    if (isset($_POST["Code"])) {
                    $code=$_POST["Code"]; 
            ?>
            <?php echo $code; ?>
            <?php
                    } 
            ?> 
            <?php  
                }
            ?>
        </div>-->
            
            
        <!-- </form>
        <br> -->
        	
        	
       <!--  <input type="text" name="" id="txtHint"> -->
       <!-- 
    </div> -->

</body>
</html>