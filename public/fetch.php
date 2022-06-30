<?php
    include("../db/conexion.php");
    if(isset($_POST['request'])){

        $request = $_POST['request'];

        $query = "SELECT * FROM disenadores WHERE region = '$request'";
        $result= mysqli_query($conn,$query);
        $count= mysqli_num_rows($result);
    
?>
<table class="table">
    <?php
    if($count){
    ?>
    <thead>
        <tr>
        <td></td>
        <td><h1>Nombre </h1> </td>
        <td> <h1>descripcion </h1></td>
        </tr>
        <?php
    }else{
        echo"no se encuentran registros";
    }
        ?>
    </thead>
    <tbody>
        <?php
        while($row = mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><img height="100" src="data:image/jpg;base64, <?php echo base64_encode($row['imagen']) ?>"></td>
            <td style="text-align:center"><?php echo $row['nombre'] ?></td>
            <td style="text-align:center"><?php echo $row['descripcion'] ?></td>
            <td style="text-align:center"><?php echo $row['correo'] ?></td>
            </tr>
            <?php
        }
            ?>
    </tbody>
</table>
<?php
        }
            ?>