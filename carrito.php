<?php
session_start();

// Agregamos un producto al carrito sólo si todas las variables del formulario tienen un valor
if(isset($_POST["producto"]) && isset($_POST["cantidad"]))
{
    agregar_producto_carrito();
}

// Mostramos el carrito, si no está vacío
$carrito_html = mostrar_tabla_carrito();

// En caso de que el carrito este vacío
$carrito_vacio = !isset($_SESSION["carrito"]);

// FUNCIONES 
function agregar_producto_carrito()
{
    // Si hemos detectado un producto repetido, añadimos a la cantidad en lugar de añadir una fila nueva
    $producto_repetido = detectar_producto_repetido();

    if($producto_repetido != -1)
    {
        $_SESSION["carrito"][$producto_repetido]["cantidad"] += $_POST["cantidad"]; // En caso de producto repetido
    }
    else
    {
        // Si es un producto no repetido, obtenemos el nombre y precio del "value" del <select>
        $nombre = explode("€", $_POST["producto"])[1];
        $precio = floatval(explode("€", $_POST["producto"])[0]);

        // Y creamos un array con la info completa del nuevo producto
        $info_producto_carrito = [
            "producto" => $nombre,
            "cantidad" => $_POST["cantidad"],
            "precio" => $precio
        ];

        // Añadimos el producto, que es un array, a la sesión
        $_SESSION["carrito"][] = $info_producto_carrito;
    }
}

function mostrar_tabla_carrito() // Muestra cada producto del carrito en elementos HTML
{
    $carrito_html = "";
    $precio_total = 0;

    if(isset($_SESSION["carrito"]))
    {
        $i = 0;
        foreach($_SESSION["carrito"] as $key => $pack)
        {
            $suma_precio_producto = $pack["precio"] * $pack["cantidad"];
            $precio_total += $suma_precio_producto;

            $carrito_html .= '<tr>';
            $carrito_html .= '  <th>' . ++$i . '</th>';
            $carrito_html .= '  <td>' . $pack["producto"] . '</td>';
            $carrito_html .= '  <td>' . $pack["precio"] . '€</td>';
            $carrito_html .= '  <td>' . $pack["cantidad"] . '</td>';
            $carrito_html .= '  <th>' . $suma_precio_producto . '€</th>';
            $carrito_html .= '</tr>';
        }

        // Añadimos una fila más en la tabla que calculará el precio total de los productos del carrito
        $carrito_html .= '<tr>';
        $carrito_html .= '  <th colspan = "5" class = "fs-5 text-end">' . $precio_total . '€</th>';
        $carrito_html .= '</tr>';
    }
    else
    {
        $carrito_html = "<p class = 'my-5 text-end'> Carrito de la compra vacío. Haga click en <i>Seguir comprando</i> para añadir algún producto. </p>";
    }

    return $carrito_html;
}

function detectar_producto_repetido()
{
    $index = -1;

    if(isset($_SESSION["carrito"]))
    {
        foreach($_SESSION["carrito"] as $i => $value) // Recorremos los elementos del carrito, para comprobar si es repetido o no
        {
            $producto = $value["precio"] . "€" . $value["producto"]; // Reconstruimos el nombre del producto

            if($producto == $_POST["producto"]) // Si coincide algún nombre, guardamos el índice
            {
                $index = $i;
                break;
            }
        }
    }

    return $index;
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

        <title> Carrito Videojuegos </title>
    </head>
    <body>
        <h1 class = "text-center my-5"> Carrito de la compra </h1>
        <div class = "container">
            <div class = "row">
                <div class = "col-12 col-lg-6">
                    <table class = "table container text-end">
                        <thead>
                            <tr>
                                <th scope = "col"> # </th>
                                <th scope = "col"> Producto </th>
                                <th scope = "col"> Precio </th>
                                <th scope = "col"> Cantidad </th>
                                <th scope = "col"> Total </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                echo $carrito_html;
                            ?>
                        </tbody>
                    </table>
                    <div class = "my-3" dir = "rtl">
                        <form action = "./pedidos.php" method = "post" class = "<?php if ($carrito_vacio) echo "d-none"; else echo "d-inline" ?>">
                            <input type = "text" name = "procesar_pedido" class = "d-none" value = "1">
                            <button class = "btn btn-success"> Procesar pedido </button>
                        </form>
                        <a href = "./inicio.php"><button class = "btn btn-primary"> Seguir comprando </button></a>
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