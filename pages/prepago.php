<?php
session_start();
include_once("../components/header.php");

// Validar que haya productos en el carrito
$carrito = $_SESSION['carrito'] ?? [];
if (empty($carrito)) {
    header("Location: carrito.php");
    exit();
}

// Calcular totales
$total = 0;
foreach ($carrito as $id => $item) {
    if (!isset($item['precio'], $item['cantidad'])) {
        continue;
    }
    $subtotal = (float)$item['precio'] * (int)$item['cantidad'];
    $carrito[$id]['subtotal'] = $subtotal;
    $total += $subtotal;
}

// Manejo de errores
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8');
    $mensaje = '';
    
    switch($error) {
        case 'campos_vacios':
            $mensaje = 'Por favor complete todos los campos obligatorios.';
            break;
        case 'email_invalido':
            $mensaje = 'El email ingresado no es válido.';
            break;
        case 'datos_largos':
            $mensaje = 'Algunos campos exceden la longitud permitida.';
            break;
        case 'envio_no_seleccionado':
            $mensaje = 'Debe seleccionar un método de entrega.';
            break;
        default:
            $mensaje = 'Ocurrió un error. Por favor intente nuevamente.';
    }
    
    if ($mensaje) {
        echo '<div class="alert alert-danger alert-dismissible fade show container-prepago" role="alert">
                ' . htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
              </div>';
    }
}
?>

<h1 class="titu" id="titulo-formulario">¡Ya casi listo!</h1>

<div class="container-prepago">
    <div class="prepago-grid">
        
        <!-- FORMULARIO -->
        <div class="card" id="card_con">
            <div class="card-body">
                <h4 style="color: var(--color-accent); margin-bottom: 20px;">Datos de contacto</h4>
                
                <form action="datos_compra.php" method="post">

                    <!-- Datos personales -->
                    <div class="fila-datos-personales">
                        <div>
                            <label for="nom">Nombre y apellido:</label>
                            <input type="text" 
                                   name="nombre_apellido" 
                                   id="nom" 
                                   placeholder="Ingrese su nombre y apellido"
                                   maxlength="100"
                                   required> 
                        </div>
                        <div>
                            <label for="mail">Mail:</label>
                            <input type="email" 
                                   name="email" 
                                   id="mail" 
                                   placeholder="ejemplo@correo.com"
                                   maxlength="100"
                                   required> 
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div style="margin-bottom: 15px;">
                        <label for="tel">Teléfono:</label>
                        <input type="tel" 
                               name="telefono" 
                               id="tel" 
                               placeholder="Ej: +54 11 1234-5678"
                               pattern="[0-9+\-\s()]*"
                               maxlength="20"
                               required>
                    </div>

                    <!-- Comentarios -->
                    <div class="area-comentarios">
                        <label for="comentarios">Comentarios/observaciones (opcional):</label>
                        <textarea id="comentarios" 
                                  name="comentarios" 
                                  rows="3" 
                                  maxlength="500"
                                  placeholder="Escribe tu mensaje aquí (máximo 500 caracteres)..."></textarea>
                    </div>

                    <!-- OPCIONES DE ENVÍO -->
                    <div class="mt-4">
                        <h4 style="color: var(--color-accent); margin-bottom: 10px;">Método de entrega</h4>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metodo_envio" id="envio_domicilio" value="domicilio">
                            <label class="form-check-label" for="envio_domicilio">
                                🚚 Envío a domicilio (el costo se coordina por WhatsApp con nosotros).  
                                <br><small>El cliente se hace cargo del costo total del envío y debe contactarse al <strong>11-3813-1307</strong>.</small>
                            </label>
                        </div>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="metodo_envio" id="retiro_local" value="retiro">
                            <label class="form-check-label" for="retiro_local">
                                🏬 Retiro por <strong>Av. Elcano 4012</strong> (sin costo)
                            </label>
                        </div>

                        <!-- Campo de dirección, aparece solo si elige envío -->
                        <div id="direccion_envio_container" class="mt-3" style="display: none;">
                            <label for="direccion_envio">Dirección de entrega:</label>
                            <input type="text" class="form-control" id="direccion_envio" name="direccion_envio"
                                   placeholder="Ej: Calle 1234, Piso 2, Depto B" maxlength="150">
                        </div>
                    </div>

                    <div class="alert alert-info mt-4 mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-1"><strong>Compra 100% Segura</strong></h5>
                                <p class="mb-0">Protegemos tu privacidad y tus datos en cada paso, para que tu experiencia de compra sea segura y confiable.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="submit-container">
                        <button type="submit" class="btn btn-success btn-lg" style="width: 100%;">
                            Continuar al pago
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- RESUMEN DEL CARRITO -->
        <div class="resumen-carrito">
            <h3>Resumen de tu compra</h3>
            
            <div class="productos-lista">
                <?php foreach ($carrito as $id => $item): ?>
                    <?php if (!isset($item['foto'], $item['nombre'], $item['cantidad'], $item['precio'], $item['subtotal'])) continue; ?>
                    <div class="producto-resumen">
                        <img src="../img/<?= htmlspecialchars($item['foto'], ENT_QUOTES, 'UTF-8') ?>" 
                             alt="Imagen de <?= htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8') ?>" 
                             class="producto-img" width="80" height="80">
                        
                        <div class="producto-info">
                            <div class="producto-nombre"><?= htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="producto-detalle">Cantidad: <?= htmlspecialchars((int)$item['cantidad'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="producto-detalle">Precio unitario: $<?= htmlspecialchars(number_format($item['precio'], 2), ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="producto-precio">Subtotal: $<?= htmlspecialchars(number_format($item['subtotal'], 2), ENT_QUOTES, 'UTF-8') ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="total-container">
                <div class="total-row">
                    <span>Total a pagar:</span>
                    <span>$<?= htmlspecialchars(number_format($total, 2), ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const envio = document.getElementById("envio_domicilio");
    const retiro = document.getElementById("retiro_local");
    const direccion = document.getElementById("direccion_envio_container");

    envio.addEventListener("change", () => {
        if (envio.checked) direccion.style.display = "block";
    });

    retiro.addEventListener("change", () => {
        if (retiro.checked) direccion.style.display = "none";
        document.getElementById("direccion_envio").value = "";
    });
});
</script>

<?php include_once("../components/footer.php"); ?>
