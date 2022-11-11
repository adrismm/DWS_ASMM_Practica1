<?php
session_start();

const day = 60 * 60 * 24;

$accion_realizada = ""; // Variable para el pedido realizado, el historial borrado y el último pedido borrado
$fecha_pedido = "";
$cantidad_pedidos = 0;

if(isset($_COOKIE["fecha_pedido"]))
{
    $fecha_pedido = $_COOKIE["fecha_pedido"];
}

if(isset($_COOKIE["cantidad_pedidos"]))
{
    $cantidad_pedidos = $_COOKIE["cantidad_pedidos"];
}

// Comprobamos lo que hacer, si recibimos por POST hemos llegado por un botón y no por url
$botonProcesarPedido = isset($_POST["procesar_pedido"]);
$botonBorrarHistorial = isset($_POST["borrar_historial"]);
$botonBorrarUltimoPedido = isset($_POST["borrar_ultimo_pedido"]);

if($botonBorrarUltimoPedido) // Al pulsar botón "Borrar último pedido"
{
    borrarUltimoPedido();
}
else if($botonBorrarHistorial) // Al pulsar botón "Borrar historial"
{
    borrarHistorial();
}
else if($botonProcesarPedido) // Al pulsar botón "Procesar pedido"
{
    procesarPedido();
}

$datos_html = mostrar_info(); // Mostramos los datos del historial

function mostrar_info()
{
    global $accion_realizada, $fecha_pedido, $cantidad_pedidos;

    $html = "";

    if($accion_realizada) // En caso de haber realizado alguna acción
    {
        $html .= "<h2 class = 'mb-5 fs-4 text-center'> $accion_realizada </h2>";
    }

    if($cantidad_pedidos != 0) // Si hay pedidos en el historial
    {
        if($cantidad_pedidos == 1)
        {
            $html .= "<p class = 'my-1'> Has realizado 1 compra. </p>";
        }
        else
        {
            $html .= "<p class = 'my-1'> Has realizado $cantidad_pedidos compras. </p>";
        }

        $html .= "<p class = 'my-1'> Su última compra ha sido realizada el $fecha_pedido . </p>";
    }
    else
    {
        $html .= "<p class = 'my-2 text-center'> Aún no has realizado ningún pedido. Si quieres tramitar tu pedido: <a class = 'btn btn-primary' href = './carrito.php' role = 'button'> Carrito </a> </p>";
    }

    return $html;
}

function procesarPedido()
{
    global $accion_realizada, $fecha_pedido, $cantidad_pedidos;

    $accion_realizada = "¡Pedido realizado con éxito!";
    $fecha_pedido = date("d/m/Y H:i:s");
    $cantidad_pedidos = 1;

    if(isset($_COOKIE["cantidad_pedidos"])) // En caso de no ser el primer pedido, incrementamos la cantidad de pedidos
    {
        $cantidad_pedidos = $_COOKIE["cantidad_pedidos"] + 1;
    }

    setcookie("cantidad_pedidos", $cantidad_pedidos, time() + (day * 3650), "/");
    setcookie("fecha_pedido", $fecha_pedido, time() + (day * 3650), "/");

    unset($_SESSION["carrito"]); // Borramos el carrito
}

function borrarUltimoPedido()
{
    global $accion_realizada, $fecha_pedido, $cantidad_pedidos;

    echo "¡Hola!";

    if(isset($_COOKIE["cantidad_pedidos"]))
    {
        if($_COOKIE["cantidad_pedidos"] != 0)
        {
            $accion_realizada = "Pedido borrado correctamente.";
            $fecha_pedido = $_COOKIE["fecha_pedido"];
            $cantidad_pedidos = $_COOKIE["cantidad_pedidos"] - 1;

            if($_COOKIE["cantidad_pedidos"] == 1)
            {
                borrarHistorial();
            }
            else
            {
                setcookie("cantidad_pedidos", $cantidad_pedidos, time() + (day * 3650), "/");
                setcookie("fecha_pedido", $fecha_pedido, time() + (day * 3650), "/");
            }
        }
        else
        {
            $accion_realizada = "No puedes borrar un pedido que no tienes.";
        }
    }
    else
    {
        $accion_realizada = "No puedes borrar un pedido que no tienes.";
    }
}

function borrarHistorial()
{
    global $accion_realizada, $cantidad_pedidos;

    setcookie("cantidad_pedidos", "", time() - 36000, "/");
    setcookie("fecha_pedido", "", time() - 36000, "/");

    $accion_realizada = "Historial de pedidos borrado con éxito.";
    $cantidad_pedidos = 0;
}
?>

<!DOCTYPE html>
<html lang = "es">
    <head>
        <meta charset = "utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name = "viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel = "stylesheet" href = "./src/css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

        <title> Historial Pedidos </title>
    </head>
    <body>
        <h1 class = "text-center my-5"> Historial de pedidos realizados </h1>
        <div class = "container">
            <div class = "row">
                <div class = "col-12 col-lg-6">
                    <?php echo $datos_html; ?>
                    <div class = "mt-5" dir = "rtl">
                        <form action = "./pedidos.php" method = "post" class = "<?php if ($cantidad_pedidos == 0) echo "d-none"; else echo "d-inline" ?>">
                            <input type = "text" name = "borrar_historial" class = "d-none" value = "1">
                            <button class = "btn btn-danger"> Borrar historial </button>
                        </form>
                        <form action = "./pedidos.php" method = "post" class = "<?php if ($cantidad_pedidos == 0) echo "d-none"; else echo "d-inline" ?>">
                            <input type = "text" name = "borrar_ultimo_pedido" class = "d-none" value = "1">
                            <button class = "btn btn-danger"> Borrar último pedido </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class = "bg-dark text-light p-3 fixed-bottom text-center">
            <div class = "container">
                <div class = "row">
                    <div class = "col-12 col-lg-6">
                        <label> Desarrollo Web en Entorno Servidor. Práctica Tema 1 </label>
                    </div>
                    <div class = "col-12 col-lg-6">
                        <label> Adrián Sánchez-Matamoros Martín </label>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>