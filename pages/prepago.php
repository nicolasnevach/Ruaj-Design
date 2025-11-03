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
    $subtotal = $item['precio'] * $item['cantidad'];
    $carrito[$id]['subtotal'] = $subtotal;
    $total += $subtotal;
}

// Manejo de errores
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    $mensaje = '';
    
    switch($error) {
        case 'campos_vacios':
            $mensaje = 'Por favor complete todos los campos obligatorios.';
            break;
        case 'email_invalido':
            $mensaje = 'El email ingresado no es válido.';
            break;
        case 'bd_error':
            $mensaje = 'Hubo un error al procesar su solicitud. Intente nuevamente.';
            break;
    }
    
    if ($mensaje) {
        echo '<div class="alert alert-danger alert-dismissible fade show container-prepago" role="alert">
                ' . $mensaje . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

                    <!-- Datos personales en 2 columnas -->
                    <div class="fila-datos-personales">
                        <div>
                            <label for="nom">Nombre y apellido:</label>
                            <input type="text" name="nombre_apellido" id="nom" placeholder="Ingrese su nombre y apellido" required> 
                        </div>
                        <div>
                            <label for="mail">Mail:</label>
                            <input type="email" name="email" id="mail" placeholder="Ingrese su email" required> 
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div style="margin-bottom: 15px;">
                        <label for="tel">Teléfono:</label>
                        <input type="tel" name="telefono" id="tel" placeholder="Ingrese su teléfono" required>
                    </div>

                    <!-- Comentarios -->
                    <div class="area-comentarios">
                        <label for="comentarios">Comentarios/observaciones:</label>
                        <textarea id="comentarios" name="comentarios" rows="3" placeholder="Escribe tu mensaje aquí..."></textarea>
                    </div>

                    <div class="alert alert-info mt-4 mb-4" role="alert">
        <div class="d-flex align-items-center">
          
          <div>
            <h5 class="mb-1"><strong>Compra 100% Segura</strong></h5>
            <p class="mb-0">Tu compra está protegida. Realizamos envíos seguros y coordinamos con vos todos los detalles para garantizar que recibas tu producto en perfectas condiciones.</p>
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
                    <div class="producto-resumen">
                        <img src="../img/<?= htmlspecialchars($item['foto']) ?>" 
                             alt="<?= htmlspecialchars($item['nombre']) ?>" 
                             class="producto-img">
                        
                        <div class="producto-info">
                            <div class="producto-nombre">
                                <?= htmlspecialchars($item['nombre']) ?>
                            </div>
                            <div class="producto-detalle">
                                Cantidad: <?= (int)$item['cantidad'] ?>
                            </div>
                            <div class="producto-detalle">
                                Precio unitario: $<?= number_format($item['precio'], 2) ?>
                            </div>
                            <div class="producto-precio">
                                Subtotal: $<?= number_format($item['subtotal'], 2) ?>
                            </div>
                            
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

<?php
include_once("../components/footer.php");
?>