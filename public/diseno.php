<?php
    include '../template/header.php';
?>

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">>
        <style>
            .drawing-area{
                position: absolute;
                top: 60px;
                left: 122px;
                z-index: 10;
                width: 200px;
                height: 400px;
                margin-left: auto;
                margin-right: auto;
                display: block;
            }

            .canvas-container{
                width: 200px; 
                height: 400px; 
                position: relative; 
                user-select: none;
                margin-left: auto;
                margin-right: auto;
                display: block;
            }

            #tshirt-div{
                width: 452px;
                height: 548px;
                position: relative;
                background-color: #fff;
                margin-left: auto;
                margin-right: auto;
                display: block;
            }

            #canvas{
                position: absolute;
                width: 200px;
                height: 400px; 
                left: 0px; 
                top: 0px; 
                user-select: none; 
                cursor: default;
                margin-left: auto;
                margin-right: auto;
                display: block;
            }
        </style>
    </head>
    <body>
        <!-- Crea el contenedor de la herramienta -->
        <div id="tshirt-div">
            <!-- 
                Inicialmente, la imagen tendrá la camiseta de fondo que tiene transparencia.
                Entonces, simplemente podemos actualizar el color con CSS o JavaScript dinámicamente
            -->
            <img id="tshirt-backgroundpicture" src="./img/background_tshirt.png"/>

            <div id="drawingArea" class="drawing-area">					
                <div class="canvas-container">
                    <canvas id="tshirt-canvas" width="200" height="400"></canvas>
                </div>
            </div>
        </div>
        
        <p>To remove a loaded picture on the T-Shirt select it and press the <kbd>DEL</kbd> key.</p>
        <!-- La selección que permitirá al usuario elegir uno de los diseños estáticos. -->
        <br>
        <label for="tshirt-design">T-Shirt Design:</label>
        <select id="tshirt-design">
            <option value="">Select one of our designs ...</option>
            <option value="./batman.png">Batman</option>
        </select>

        <!-- El Select que permite al usuario cambiar el color de la camiseta -->
        <br><br>
        <label for="tshirt-color">T-Shirt Color:</label>
        <select id="tshirt-color">
            <!-- Puede agregar cualquier color con una nueva opción y definiendo su código hexadecimal -->
            <option value="#fff">White</option>
            <option value="#000">Black</option>
            <option value="#f00">Red</option>
            <option value="#008000">Green</option>
            <option value="#ff0">Yellow</option>
            <option value="#dd14bb">Moradito</option>
        </select>

        <br><br>
        <label for="tshirt-custompicture">Upload your own design:</label>
        <input type="file" id="tshirt-custompicture" />
        
        <!-- Incluya Fabric.js en la página -->
        <script src="./fabric.js-521/dist/fabric.min.js"></script>

        <script>
            let canvas = new fabric.Canvas('tshirt-canvas');

            function updateTshirtImage(imageURL){
                fabric.Image.fromURL(imageURL, function(img) {                   
                    img.scaleToHeight(300);
                    img.scaleToWidth(300); 
                    canvas.centerObject(img);
                    canvas.add(img);
                    canvas.renderAll();
                });
            }
            
            // Actualiza el color de la camiseta según el color seleccionado por el usuario.
            document.getElementById("tshirt-color").addEventListener("change", function(){
                document.getElementById("tshirt-div").style.backgroundColor = this.value;
            }, false);

            // Actualiza el color de la camiseta según el color seleccionado por el usuario.
            document.getElementById("tshirt-design").addEventListener("change", function(){

                // Llame al método updateTshirtImage proporcionando como primer argumento la URL
                // de la imagen proporcionada por la selección
                updateTshirtImage(this.value);
            }, false);

            // Cuando el usuario hace clic en cargar una imagen personalizada
            document.getElementById('tshirt-custompicture').addEventListener("change", function(e){
                var reader = new FileReader();
                
                reader.onload = function (event){
                    var imgObj = new Image();
                    imgObj.src = event.target.result;

                    // Cuando se cargue la imagen, cree la imagen en Fabric.js
                    imgObj.onload = function () {
                        var img = new fabric.Image(imgObj);

                        img.scaleToHeight(300);
                        img.scaleToWidth(300); 
                        canvas.centerObject(img);
                        canvas.add(img);
                        canvas.renderAll();
                    };
                };

                // Si el usuario seleccionó una imagen, cárgala
                if(e.target.files[0]){
                    reader.readAsDataURL(e.target.files[0]);
                }
            }, false);

             // Cuando el usuario selecciona una imagen que se ha agregado y presiona la tecla SUPR
             // ¡El objeto será eliminado!
            document.addEventListener("keydown", function(e) {
                var keyCode = e.keyCode;

                if(keyCode == 46){
                    console.log("Removing selected element on Fabric.js on DELETE key !");
                    canvas.remove(canvas.getActiveObject());
                }
            }, false);
        </script>
    </body>

</main>
<?php
    include '../template/footer.php';
?>