<footer id="site-footer"> 
  <p>Sheva © <?php echo date("Y"); ?> - Todos los derechos reservados</p>
</footer>

<!-- Botones flotantes en esquina inferior izquierda -->
<div class="botones-flotantes">

<!-- Botón de WhatsApp -->
<a href="https://wa.me/541138131307" target="_blank" class="btn-whatsapp" title="Contactar por WhatsApp">
        <img src="https://img.icons8.com/ios-filled/32/ffffff/whatsapp.png" alt="WhatsApp">
    </a>

    
    <!-- Botón de volver arriba (flecha) -->
    <button id="btnScrollTop" class="btn-scroll-top" onclick="scrollToTop()" title="Volver arriba">
        ↑
    </button>

    
</div>

<!-- Script para botón de subir -->
<script>
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Mostrar/ocultar flechita según scroll
const btnScrollTop = document.getElementById("btnScrollTop");

window.addEventListener("scroll", () => {
    if (window.scrollY > 200) {
        btnScrollTop.style.display = "block";
    } else {
        btnScrollTop.style.display = "none";
    }
});

// Ocultar al cargar la página
window.addEventListener("DOMContentLoaded", () => {
    btnScrollTop.style.display = "none";
});
</script>

<!-- BOOTSTRAP -->
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>
</html>
