<?php
// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
?>

<h1 class="titu" id="titulo-formulario">¡Ya casi listo!</h1>

<div class="container-prepago">
    <div class="prepago-grid">

        <!-- FORMULARIO -->
        <div class="card" id="card_con">
            <div class="card-body">
                <h4 style="color: var(--color-accent); margin-bottom: 20px;">Datos de contacto</h4>

                <form action="datos_compra.php" method="post" id="form-prepago">

                    <!-- Datos personales -->
                    <div class="fila-datos-personales">
                        <div>
                            <label for="nom">Nombre y apellido:</label>
                            <input type="text" name="nombre_apellido" id="nom" maxlength="100" required>
                        </div>

                        <div>
                            <label for="mail">Mail:</label>
                            <input type="email" name="email" id="mail" maxlength="100" required>
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div style="margin-bottom: 15px;">
                        <label for="tel">Teléfono (solo números y espacios):</label>
                        <input 
                            type="text" 
                            name="telefono" 
                            id="tel" 
                            maxlength="20" 
                            required 
                            pattern="[0-9 ]+" 
                            placeholder="Ej: 11 3813 1307"
                        >
                        <div id="tel_error" style="color:red;display:none;">
                            El teléfono solo puede contener números y espacios.
                        </div>
                    </div>

                    <!-- Comentarios -->
                    <div class="area-comentarios">
                        <label for="comentarios">Comentarios/observaciones (opcional):</label>
                        <textarea id="comentarios" name="comentarios" rows="3" maxlength="500"></textarea>
                    </div>

                    <!-- OPCIONES DE ENVÍO -->
                    <div class="mt-4">
                        <h4 style="color: var(--color-accent); margin-bottom: 10px;">Método de entrega</h4>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metodo_envio" id="envio_domicilio" value="domicilio">
                            <label class="form-check-label" for="envio_domicilio"> 🚚 Envío a domicilio </label>
                        </div>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="radio" name="metodo_envio" id="retiro_local" value="retiro">
                            <label class="form-check-label" for="retiro_local"> 🏬 Retiro por Av. Elcano 4012 </label>
                        </div>

                        <!-- Campo de dirección -->
                        <div id="direccion_envio_container" class="mt-3" style="display: none;">
                            <label for="direccion_envio">Dirección de entrega:</label>
                            <input type="text" class="form-control" id="direccion_envio" name="direccion_envio" maxlength="150">
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
                <?php foreach ($carrito as $item): ?>
                    <div class="producto-resumen">
                        <img src="../img/<?= $item['foto'] ?>" width="80" height="80">
                        <div class="producto-info">
                            <div><?= $item['nombre'] ?></div>
                            <div>Cantidad: <?= $item['cantidad'] ?></div>
                            <div>Precio unitario: $<?= number_format($item['precio'],2) ?></div>
                            <div>Subtotal: $<?= number_format($item['subtotal'],2) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="total-container">
                <div class="total-row">
                    <span>Total a pagar:</span>
                    <span>$<?= number_format($total, 2) ?></span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const telInput = document.getElementById("tel");
    const telError = document.getElementById("tel_error");
    const form = document.getElementById("form-prepago");

    // VALIDACIÓN LIVE (solo números y espacios)
    telInput.addEventListener("input", () => {
        const ok = /^[0-9 ]*$/.test(telInput.value);
        telError.style.display = ok ? "none" : "block";
    });

    // VALIDAR ANTES DE ENVIAR
    form.addEventListener("submit", function(e) {
        const ok = /^[0-9 ]+$/.test(telInput.value);
        if (!ok) {
            e.preventDefault();
            telError.style.display = "block";
        }
    });

    const envio = document.getElementById("envio_domicilio");
    const retiro = document.getElementById("retiro_local");
    const direccion = document.getElementById("direccion_envio_container");

    envio.addEventListener("change", () => direccion.style.display = "block");
    retiro.addEventListener("change", () => {
        direccion.style.display = "none";
        document.getElementById("direccion_envio").value = "";
    });
});
</script>

<?php include_once("../components/footer.php"); ?>
