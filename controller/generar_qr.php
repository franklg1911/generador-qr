<!-- 
-------------------------------------------------------------------------------------------------------------------------
Descripción general
-------------------------------------------------------------------------------------------------------------------------
Este archivo php se encarga de generar un código QR a partir de un texto ingresado por el usuario en un formulario.
El código QR se genera utilizando la librería "phpqrcode" y se guarda en un directorio temporal. Luego, se muestra el 
código QR generado en una página web junto con opciones para generar otro código o descargar la imagen del código QR.
-------------------------------------------------------------------------------------------------------------------------
Palabras reservadas "PHP"
-------------------------------------------------------------------------------------------------------------------------
- empty: Verifica si una variable está vacía.
- include: Incluye y evalúa el archivo especificado.
- htmlspecialchars: Convierte caracteres especiales a entidades HTML.
- !is_dir: Verifica si un directorio no existe.
- mkdir: Crea un directorio.
- 077, true: Parámetros para la función mkdir que indican permisos y si se deben crear directorios padre.
- md5: Calcula el hash MD5 de una cadena.
- QRcode::png: Genera un código QR y lo guarda en un archivo.
- 'L', 4 2: Parámetros para la función QRcode::png que indican el nivel de corrección, tamaño de la matriz y margen.
- basename: Devuelve el nombre del archivo de una ruta.
-------------------------------------------------------------------------------------------------------------------------
Declaraciones "PHP"
-------------------------------------------------------------------------------------------------------------------------
- $_SERVER['REQUEST_METHOD']: Contiene el método de solicitud utilizado para acceder a la página (GET, POST, etc.).
- $_POST['qrtext']: Contiene el texto ingresado por el usuario en el formulario.
- $text: Contiene el texto sanitizado ingresado por el usuario.
- $tempDir: Contiene la ruta del directorio temporal donde se guardará la imagen QR.
- $filename: Contiene el nombre del archivo donde se guardará la imagen QR.
-->

<?php

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['qrtext'])) {

    // Incluimos la libreria de "phpqrcode"
    include "../libs/phpqrcode/qrlib.php";

    // Sanitiza la entrada de usuario
    $text = htmlspecialchars(($_POST['qrtext']));

    // Directorio temporal para almacenar la imagen qr
    $tempDir = "../temp/";

    // Condicinonal para verificar si el directorio existe, si no existe lo crea
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    // Genera un nombre único para el archivo
    $filename = $tempDir . 'qr_' . md5($text) . '.png';

    // Generamos el codigo qr: parámetros (texto, archivo de salida, nivel de corrección, tamaño de la matriz, margen)
    QRcode::png($text, $filename, 'L', 4, 2);
} else {
    // Si no ingresa nada
    header(("Location: ../index.php"));
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Generador QR</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center text-secondary">TU CODIGO QR</h1>

        <img src="<?php echo $filename; ?>" alt="Código QR" class="img-fluid mx-auto d-block" />

        <div class="text-center mt-4">
            <a href="../index.php" class="btn btn-secondary">Generar otro código QR</a>
            <a href="descargar_qr.php?file=<?php echo basename($filename); ?>" class="btn btn-warning">Descargar imagen
                QR</a>
        </div>

    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
