<!DOCTYPE html>
<html lang = "es">
    <head>
        <meta charset = "utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name = "viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel = "stylesheet" href = "./src/css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

        <title> Tienda Videojuegos </title>
    </head>
    <body>
        <h1 class = "text-center my-5 _decoration"> Selecciona tu videojuego: </h1>
        <div class = "container">
            <div class = "row">
                <div class = "col-12 col-lg-6">
                    <form action = "./carrito.php" class="my-5" method="post">
                        <div class = "mb-3">
                            <label for = "cart-item"> Elige un producto: </label>
                            <select id = "cart-item" class = "form-select" name = "producto">
                                <option value = "44.99€ God of War 2"> God of War 2: 44.99€ </option>
                                <option value = "65€ Call of Duty Modern Warfare II"> Call of Duty Modern Warfare II: 65€ </option>
                                <option value = "50€ Fifa 2023"> Fifa 2023: 50€ </option>
                                <option value = "70€ Grand Theft Auto VI"> Grand Theft Auto VI: 70€ </option>
                                <option value = "29.95€ Crash Twinsanity"> Crash Twinsanity: 29.95€ </option>
                                <option value = "33.33€ Jak X"> Jak X: 33.33€ </option>
                                <option value = "38.90€ Monster Hunter World"> Monster Hunter World: 38.90€ </option>
                                <option value = "59.75€ Pokémon Escarlata"> Pokémon Escarlata: 59.75€ </option>
                                <option value = "19.99€ Minecraft"> Minecraft: 19.99€ </option>
                                <option value = "25€ LittleBigPlanet 4"> LittleBigPlanet 4: 25€ </option>
                            </select>
                        </div>
                        <div class = "mb-3">
                            <label for = "cart-item"> Cantidad: </label>
                            <input type = "number" value = "1" min = "1" class = "w-100" name = "cantidad">
                        </div>
                        <div class = "mb-3 button" dir = "rtl">
                            <button class = "btn btn-primary"> Añadir al carrito </button>
                        </div>
                    </form>
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