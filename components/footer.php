<footer class="footer">
  <div class="footer-container">
    <!-- Sección Contacto -->
    <div class="footer-section footer-bottom">
      <h3><a href="inicio.php#contacto" >Contacto</a></h3>
      <p><i class="fas fa-map-marker-alt"></i> CHACARITA, CABA</p>
      <p><i class="fas fa-phone"></i> +54 11 3813-1307</p>
      <p><i class="fas fa-envelope"></i> ruajdesign@gmail.com</p>
    </div>

    <!-- Sección Horarios -->
    <div class="footer-section">
      <h3>Horarios</h3>
      <p>Lunes a Viernes: 10:00 - 18:00</p>
      <p>Sábados y Domingos: Cerrado</p>
    </div>

    
    
    

    <!-- Sección Redes Sociales -->
    <div class="footer-section">
      <h3>Síguenos</h3>
      <div class="social-links">
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ruajdesign@gmail.com&su=Mi%20Mueble" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="social-icon"
           aria-label="Enviar correo a Ruaj Design">
          <img src="../img/gmail.png" alt="Enviar correo" width="40" height="40">
        </a>
        <a href="https://www.instagram.com/ruajmuebles/" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="social-icon"
           aria-label="Visitar Instagram de Ruaj Design">
          <img src="../img/instagram.png" alt="Instagram" width="40" height="40">
        </a>
        <a href="https://www.facebook.com/ruajdesign" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="social-icon"
           aria-label="Visitar Facebook de Ruaj Design">
          <img src="../img/facebook.png" alt="Facebook" width="40" height="40">
        </a>
        <a href="https://wa.me/541138131307" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="social-icon"
           aria-label="Contactar por WhatsApp">
          <img src="../img/wpp.png" alt="WhatsApp" width="40" height="40">
        </a>
      </div>
    </div>

    <div class="footer-section">
  <h3>Medios de pago</h3>
  <div class="social-links">
    <div class="social-icon" aria-label="Pago con Mercado Pago">
      <img src="../img/mp.png" alt="Mercado Pago" width="40" height="40">
    </div>
    <div class="social-icon" aria-label="Pago con Visa">
      <img src="../img/visa.png" alt="Visa" width="40" height="40">
    </div>
    <div class="social-icon" aria-label="Pago con Mastercard">
      <img src="../img/master.png" alt="Mastercard" width="40" height="40">
    </div>
    <div class="social-icon" aria-label="Pago con American Express">
      <img src="../img/amex.png" alt="American Express" width="40" height="40">
    </div>
    <div class="social-icon" aria-label="Pago con Diners Club">
      <img src="../img/diners.png" alt="Diners Club" width="40" height="40">
    </div>
    <div class="social-icon" aria-label="Pago con CABAL">
      <img src="../img/cabal.png" alt="CABAL" width="40" height="40">
    </div>
    <div class="social-icon" aria-label="Pago con Banelco">
      <img src="../img/banelco.png" alt="Banelco" width="40" height="40">
    </div>
  
  </div>
</div>

  </div>

  <!-- Copyright -->
  <div class="footer-bottom">
    <p>&copy; <?php echo htmlspecialchars(date("Y"), ENT_QUOTES, 'UTF-8'); ?> Ruaj Muebles. Todos los derechos reservados. Por <a href="https://www.linkedin.com/in/nicolas-de-vicenzo-nevach-a0107227b/" target="_blank" >Nicolás Nevach</a> </p>
  </div>
</footer>

<!-- Botones flotantes en esquina inferior derecha -->
<div class="botones-flotantes">
  <!-- Botón de WhatsApp -->
  <a href="https://wa.me/541138131307" 
     target="_blank" 
     rel="noopener noreferrer" 
     class="btn-whatsapp" 
     aria-label="Contactar por WhatsApp">
    <img src="../img/wpp.png" alt="WhatsApp flotante" width="32" height="32">
  </a>
    
  <!-- Botón de volver arriba -->
  <button id="btnScrollTop" 
          class="btn-scroll-top" 
          onclick="scrollToTop()" 
          aria-label="Volver arriba">
    ↑
  </button>
</div>

<!-- Script para botón de subir -->
<script>
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Mostrar/ocultar botón según scroll
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