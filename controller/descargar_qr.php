<!-- 
-------------------------------------------------------------------------------------------------------------------------
Descripción general
-------------------------------------------------------------------------------------------------------------------------
Este archivo PHP se encarga de descargar un archivo QR generado previamente. Verifica si el archivo existe y lo envía al navegador
para su descarga o muestra un mensaje de error si el archivo no se encuentra.
-------------------------------------------------------------------------------------------------------------------------
Clases "PHP"
-------------------------------------------------------------------------------------------------------------------------
- file_exists: Verifica si un archivo existe en la ruta especificada.
- header: Envía encabezados HTTP al navegador.
- Content-Description: File Transfer: Descripción del contenido.
- Content-Type: application/octet-stream: Tipo de contenido del archivo.
- Content-Disposition: attachment; filename: Indica que el contenido es un archivo adjunto y sugiere un nombre de archivo.
- Expires: 0: Indica que el contenido no debe ser almacenado en caché.
- Cache-Control: must-revalidate: Indica que el contenido debe ser validado antes de ser almacenado en caché.
- Pragma: public: Indica que el contenido es público y puede ser almacenado en caché.
- Content-Length: Indica la longitud del contenido en bytes.
- filesize: Devuelve el tamaño de un archivo en bytes.
- readfile: Lee un archivo y lo envía al navegador.
-------------------------------------------------------------------------------------------------------------------------
Variables "PHP"
-------------------------------------------------------------------------------------------------------------------------
- $file: Contiene la ruta del archivo a descargar, concatenando el directorio temporal y el nombre del archivo.
- $_GET['file']: Contiene el nombre del archivo enviado a través de la URL.
-->
<?php

// Condicional para verificar si se ha enviado el formulario
if (isset($_GET['file'])) {

    // Asegurar que solo acceda a archivos válidos
    $file = "../temp/" . basename($_GET['file']);

    // Verificar si el archivo existe
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {

        echo "El archivo no existe";
    }
} else {
    echo "Archivo no encontrado";
}
