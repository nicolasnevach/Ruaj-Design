<footer class="footer">
  <div class="footer-container">
    <!-- Sección Contacto -->
    <div class="footer-section">
      <h3>Contacto</h3>
      <p><i class="fas fa-map-marker-alt"></i> CHACARITA, CABA</p>
      <p><i class="fas fa-phone"></i> +54 11 3813-1307</p>
      <p><i class="fas fa-envelope"></i> ruajdesign@gmail.com</p>
    </div>

    <!-- Sección Horarios -->
    <div class="footer-section">
      <h3>Horarios</h3>
      <p>Lunes a Viernes: 10:00 - 18:00</p>
      <p>Sabados y domingos: Cerrado</p>
    </div>

    <!-- Sección Redes Sociales -->
    <div class="footer-section">
      <h3>Síguenos</h3>
      <div class="social-links">
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ruajdesign@gmail.com&su=Mi%20Mueble" target="_blank" class="social-icon">
          <img src="../img/gmail.png" alt="Gmail">
        </a>
        <a href="https://www.instagram.com/ruajmuebles/" target="_blank" class="social-icon">
          <img src="../img/instagram.png" alt="Instagram">
        </a>
        <a href="https://www.facebook.com/ruajdesign" target="_blank" class="social-icon">
          <img src="../img/facebook.png" alt="Facebook">
        </a>
        <a href="https://wa.me/541138131307" target="_blank" class="social-icon">
          <img src="../img/wpp.png" alt="WhatsApp">
        </a>
      </div>
    </div>
  </div>

  <!-- Copyright -->
  <div class="footer-bottom">
    <p>&copy; <?php echo date("Y"); ?> Ruaj Muebles. Todos los derechos reservados.</p>
  </div>
</footer>

<style>
.footer {
  background-color: #2c3e50;
  color: var(--color-accent);
  padding: 40px 20px 20px;
  margin-top: 50px;
}

.footer-container {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: 0 auto;
  gap: 30px;
}

.footer-section {
  flex: 1;
  min-width: 250px;
}

.footer-section h3 {
  color: var(--color-accent);
  margin-bottom: 15px;
  font-size: 1.2rem;
  border-bottom: 2px solid var(--color-accent);
  padding-bottom: 8px;
}

.footer-section p {
  margin: 8px 0;
  line-height: 1.6;
}

.footer-section i {
  margin-right: 8px;
  color: var(--color-accent);
}

.social-links {
  display: flex;
  gap: 15px;
  margin-top: 15px;
}

.social-icon img {
  width: 40px;
  height: 40px;
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.social-icon:hover img {
  transform: scale(1.1);
  opacity: 0.8;
}

.footer-bottom {
  text-align: center;
  margin-top: 30px;
  padding-top: 20px;
  border-top: 1px solid #34495e;
  font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 768px) {
  .footer-container {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .footer-section {
    width: 100%;
  }

  .social-links {
    justify-content: center;
  }
}
</style>
  


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
