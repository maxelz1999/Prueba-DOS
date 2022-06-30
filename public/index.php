<?php
    include '../template/header.php';
  
    include("../db/conexion.php");

?>
<main class="contenedor sombra">
    <span class="label-sus info" style="font-weight:bold;">Para continuar con la busqueda de disenadores selecciona tu region aqui </span>      
    <br><br>
     <div class="contenedor">  
        
            <select name="fetchval" id="fetchval" class="select-sus" style="font-size: medium; font-weight: bold;width:220px; height:50px ;">
            <option value="0" hidden="hidden">Selecciona una region</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="1">Arica y Parinacota</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="2">Tarapaca</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="3">Antofagasta</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="4">Atacama</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="5">Coquimbo</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="6">Valparaiso</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="7">Santiago</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="8">O'Higgins</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="9">Maule</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="10">Bio-Bio</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="11">Araucania</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="12">Los Rios</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="13">Los Lagos</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="14">Aysen</option>
               <option style="width: 400px; text-align-last: center;font-size: medium;" value="15">Magallanes</option>
            </select>        
            <br><br>
    </div>
<div class="container">

<table class="table" style=' font-size:100%' >
    <thead>
    <tr>
        <td></td>
        <td><h2>Nombre </h2> </td>
        <td><h2>Descripcion </h2></td>
        <td><h2>Contacto </h2></td>

    </tr>  
</thead>

   
    <tbody>
    <?php
    $query= mysqli_query($conn,"SELECT * FROM disenadores");
    $result = mysqli_num_rows($query);
    if($result>0){
        while($data= mysqli_fetch_array($query)){
            ?>
            <tr>
                <td><img height="100" src="data:image/jpg;base64, <?php echo base64_encode($data['imagen']) ?>"></td>
                <td style="text-align:center"><?php echo $data['nombre'] ?></td>
                <td style="text-align:center"><?php echo $data['descripcion'] ?></td>
                <td style="text-align:center"><?php echo $data['correo'] ?></td>

     
            </tr>
            <?php         }
    }
    ?>
  </tbody>
</table>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#fetchval").on('change',function(){
            var value = $(this).val();
            //alert(value);
            $.ajax({
                url:"fetch.php",
                type:"POST",
                data:"request=" + value,
                beforeSend:function(){
                    $(".container").html("<span> trabajando....</span>");
                },
                success:function(data){
                    $(".container").html(data);
                }
            })
        });
    });
</script>
<?php
    include '../template/footer.php';
?>