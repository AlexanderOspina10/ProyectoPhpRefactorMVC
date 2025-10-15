<?php
// views/usuario/home/landing.php
// Variables esperadas desde el controlador:
// $productosPaginados, $totalPaginas, $page, $limit, $q

$page = $page ?? 1;
$limit = $limit ?? 8;
$q = $q ?? '';
?>

<!-- Hero Section Mejorada -->
<section id="hero" class="hero-section py-5 text-center text-white position-relative overflow-hidden">
  <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>
  <div class="container position-relative z-1">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-3">Bienvenido a Fashion Store</h1>
        <p class="lead mb-4">Descubre las últimas tendencias en moda con estilo y calidad</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
          <a href="#Catalogo" class="btn btn-primary btn-lg px-4 py-2 rounded-pill fw-semibold">
            <i class="bi bi-bag me-2"></i>Explorar Catálogo
          </a>
          <a href="#Ofertas" class="btn btn-outline-light btn-lg px-4 py-2 rounded-pill fw-semibold">
            <i class="bi bi-percent me-2"></i>Ver Ofertas
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sección de Información -->
<section id="Informacion" class="py-5 bg-light">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-6 col-md-6 content text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="info-card p-4 h-100 rounded-3 shadow-sm bg-white">
          <div class="info-icon mb-3">
            <i class="bi bi-bullseye text-primary fs-1"></i>
          </div>
          <h3 class="h4 mb-3">MISIÓN</h3>
          <p class="fst-italic text-muted">Brindar una herramienta tecnológica moderna y eficiente que permita la gestión
           integral de ventas y productos de ropa mediante una plataforma web, facilitando la
           administración del inventario, la atención a clientes y la realización de transacciones en
            línea. El sistema busca optimizar los procesos comerciales, mejorar la experiencia de compra
           y fortalecer la presencia digital de la tienda Fashion Store.</p>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 content text-center" data-aos="fade-up" data-aos-delay="200">
        <div class="info-card p-4 h-100 rounded-3 shadow-sm bg-white">
          <div class="info-icon mb-3">
            <i class="bi bi-eye text-primary fs-1"></i>
          </div>
          <h3 class="h4 mb-3">VISIÓN</h3>
          <p class="fst-italic text-muted">Convertirse en un sistema de información líder en el comercio electrónico de moda,
           reconocido por su innovación, facilidad de uso y seguridad.
           A mediano plazo, Fashion Store aspira a consolidarse como una plataforma que
           promueva el crecimiento digital de los negocios de ropa, impulsando el comercio virtual
           y el desarrollo tecnológico local.</p>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 content text-center" data-aos="fade-up" data-aos-delay="300">
        <div class="info-card p-4 h-100 rounded-3 shadow-sm bg-white">
          <div class="info-icon mb-3">
            <i class="bi bi-bullseye text-primary fs-1"></i>
          </div>
          <h3 class="h4 mb-3">OBJETIVO GENERAL</h3>
          <p class="fst-italic text-muted">Desarrollar un sistema de información web para la gestión y venta de productos de
          moda, que permita registrar, consultar, modificar y eliminar información de usuarios y
         productos, realizar ventas mediante un carrito de compras, utilizando tecnologías como
         PHP, MySQL, HTML, CSS y Bootstrap.</p>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 content text-center" data-aos="fade-up" data-aos-delay="400">
        <div class="info-card p-4 h-100 rounded-3 shadow-sm bg-white">
          <div class="info-icon mb-3">
            <i class="bi bi-list-check text-primary fs-1"></i>
          </div>
          <h3 class="h4 mb-3">OBJETIVO ESPECIFICO</h3>
          <ul>
            <li class="fst-italic text-muted">
               Diseñar la base de datos en MySQL para almacenar y organizar de manera
              estructurada la información de productos, usuarios y ventas de la tienda.
            </li>
            <li class="fst-italic text-muted">
              Implementar el sistema web utilizando PHP como lenguaje de programación.
            </li>
            <li class="fst-italic text-muted">
              Desarrollar la interfaz de usuario con HTML, CSS y Bootstrap,
              garantizando una navegación intuitiva, responsiva y visualmente atractiva.
            </li>
            <li class="fst-italic text-muted">
              Incorporar funcionalidades de venta en línea mediante un carrito de compras
              que permita seleccionar, modificar y confirmar productos.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Why Us Section -->
<section id="Por-que-nosotros" class="py-5 bg-white">
  <div class="container">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold text-dark mb-3">¿Por qué elegirnos?</h2>
      <div class="section-subtitle">
        <span class="text-muted">Descubre</span> 
        <span class="description-title text-primary">nuestras ventajas</span>
      </div>
    </div>

    <div class="row gy-4">
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card-item text-center p-4 h-100 rounded-3 shadow-sm border-0">
          <span class="number-badge mb-3">01</span>
          <h4 class="h5 mb-3">"Confeccionado con amor, pensado para ti"</h4>
          <p class="text-muted mb-0">Ropa hecha para durar y destacar.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card-item text-center p-4 h-100 rounded-3 shadow-sm border-0">
          <span class="number-badge mb-3">02</span>
          <h4 class="h5 mb-3">"Ropa con alma artística"</h4>
          <p class="text-muted mb-0">Cada prenda es una pieza única.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card-item text-center p-4 h-100 rounded-3 shadow-sm border-0">
          <span class="number-badge mb-3">03</span>
          <h4 class="h5 mb-3">"Renueva tu estilo sin perder tu esencia."</h4>
          <p class="text-muted mb-0">Diseños originales, como tú.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sección de Ofertas -->
<section id="Ofertas" class="specials-section py-5 bg-light">
  <div class="container">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold text-dark mb-3">Ofertas Especiales</h2>
      <div class="section-subtitle">
        <span class="text-muted">Nuestras</span> 
        <span class="description-title text-primary">Ofertas Exclusivas</span>
      </div>
      <p class="lead text-muted mt-3">Descubre promociones únicas para renovar tu estilo</p>
    </div>

    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-3">
        <ul class="nav nav-tabs flex-column specials-tabs" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#Hastaagotarexistencias" role="tab">
              <i class="bi bi-fire me-2"></i>Hasta agotar existencias
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#Tucumpleaños" role="tab">
              <i class="bi bi-gift me-2"></i>Tu cumpleaños
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#Diadelamujer" role="tab">
              <i class="bi bi-heart me-2"></i>Día de la mujer
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#Descuentos" role="tab">
              <i class="bi bi-percent me-2"></i>Descuentos
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#Obsequios" role="tab">
              <i class="bi bi-box-seam me-2"></i>Obsequios
            </a>
          </li>
        </ul>
      </div>
      <div class="col-lg-9 mt-4 mt-lg-0">
        <div class="tab-content specials-content">
          <div class="tab-pane fade show active" id="Hastaagotarexistencias" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3 class="fw-bold">¡Se va volando!</h3>
                <p class="fst-italic text-muted">Stock bajito. Precios increíbles. ¡Corre ya!</p>
                <p class="fst-italic text-muted">Exclusivo y por tiempo corto. ¡No te lo pierdas!</p>
                <p class="fst-italic text-muted">Si parpadeas, lo pierdes 👀</p>
                <a href="<?php echo baseUrl('catalogo#Catalogo'); ?>" class="btn btn-primary mt-3">Ver Productos</a>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="<?php echo baseUrl('img/pinzas1.png'); ?>" alt="Oferta hasta agotar existencias" class="img-fluid rounded shadow">
              </div>
            </div>
          </div>
          
          <div class="tab-pane fade" id="Tucumpleaños" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3 class="fw-bold">Regalo de cumpleaños</h3>
                <p class="fst-italic text-muted">Por ser fiel comprador te regalamos este detalle, hermoso, para que lo luzcas en la calle y tengas un bonito glamour.</p>
                <a href="<?php echo baseUrl('catalogo#Catalogo'); ?>" class="btn btn-primary mt-3">Ver Productos</a>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="<?php echo baseUrl('img/Manillera.png'); ?>" alt="Regalo de cumpleaños" class="img-fluid rounded shadow">
              </div>
            </div>
          </div>
          
          <div class="tab-pane fade" id="Diadelamujer" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3 class="fw-bold">"Mujer: eres fuerza, belleza y cambio."</h3>
                <p class="fst-italic text-muted">Para ti, que llenas el mundo de amor y color.</p>
                <p class="fst-italic text-muted">Hoy celebramos lo que ya sabíamos: que eres única.</p>
                <p class="fst-italic text-muted">Tu esencia no pasa de moda.</p>
                <a href="<?php echo baseUrl('catalogo#Catalogo'); ?>" class="btn btn-primary mt-3">Ver Productos</a>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="<?php echo baseUrl('img/Mujer4.png'); ?>" alt="Día de la mujer" class="img-fluid rounded shadow">
              </div>
            </div>
          </div>
          
          <div class="tab-pane fade" id="Descuentos" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3 class="fw-bold">Moda con rebaja, estilo sin límites!</h3>
                <p class="fst-italic text-muted">Tu outfit favorito… ahora con descuentazo 👗</p>
                <p class="fst-italic text-muted">Moda que enamora, precios que sorprenden 💖</p>
                <p class="fst-italic text-muted">Algo bonito pero barato</p>
                <a href="<?php echo baseUrl('catalogo#Catalogo'); ?>" class="btn btn-primary mt-3">Ver Productos</a>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="<?php echo baseUrl('img/Mujer7.png'); ?>" alt="Descuentos" class="img-fluid rounded shadow">
              </div>
            </div>
          </div>
          
          <div class="tab-pane fade" id="Obsequios" role="tabpanel">
            <div class="row align-items-center">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3 class="fw-bold">Nos encanta sorprenderte… ¡este es tu momento!</h3>
                <p class="fst-italic text-muted">Por varias compras te regalamos lo mejor que tenemos en nuestra pagina</p>
                <p class="fst-italic text-muted">Por cada compra especial, un regalo pensado para ti 💝</p>
                <p class="fst-italic text-muted">"¡Sí! Te damos un detalle extra solo por elegirnos"</p>
                <a href="<?php echo baseUrl('catalogo#Catalogo'); ?>" class="btn btn-primary mt-3">Ver Productos</a>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="<?php echo baseUrl('img/Obsequio.png'); ?>" alt="Obsequios" class="img-fluid rounded shadow">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Catálogo de Productos -->
<section id="Catalogo" class="py-5 bg-white">
  <div class="container">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold text-dark mb-3">Nuestro Catálogo</h2>
      <div class="section-subtitle">
        <span class="text-muted">Descubre</span> 
        <span class="description-title text-primary">Nuestros Productos</span>
      </div>
    </div>

    <!-- Buscador y filtros -->
    <div class="row mb-4">
      <div class="col-md-8">
        <form method="get" class="d-flex" action="<?php echo baseUrl('catalogo'); ?>">
          <input type="search" name="q" class="form-control me-2 rounded-pill" placeholder="Buscar por nombre o categoría" value="<?php echo htmlspecialchars($q); ?>">
          <button class="btn btn-primary rounded-pill px-4" type="submit"><i class="bi bi-search me-2"></i> Buscar</button>
        </form>
      </div>
      <div class="col-md-4 text-end">
        <form method="get" class="d-inline">
          <label class="me-2">Mostrar:</label>
          <select name="limit" class="form-select d-inline w-auto rounded-pill" onchange="this.form.submit()">
            <?php foreach ([8, 12, 24] as $op): ?>
                <option value="<?= $op ?>" <?= (!isset($_GET['limit']) && $op==8) || (isset($_GET['limit']) && $_GET['limit']==$op) ? 'selected' : '' ?>>
                    <?= $op ?>
                </option>
            <?php endforeach; ?>
          </select>
          <input type="hidden" name="q" value="<?php echo htmlspecialchars($q); ?>">
        </form>
      </div>
    </div>

    <?php if (empty($productosPaginados)): ?>
      <div class="alert alert-info text-center py-4">
        <i class="bi bi-info-circle fs-1 d-block mb-2"></i>
        <h4 class="alert-heading">No hay productos disponibles</h4>
        <p class="mb-0">Intenta con otros términos de búsqueda o revisa más tarde.</p>
      </div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($productosPaginados as $p): ?>
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card h-100 border-0 shadow-sm">
              <?php if (!empty($p['imagen'])): ?>
                <div class="product-image-container position-relative overflow-hidden">
                  <img src="<?php echo baseUrl($p['imagen']); ?>" class="card-img-top product-image" alt="<?php echo e($p['nombre']); ?>">
                  <div class="product-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
  
                  </div>
                </div>
              <?php else: ?>
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light text-muted product-placeholder">
                  <i class="bi bi-image fs-1"></i>
                </div>
              <?php endif; ?>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-semibold"><?php echo e($p['nombre']); ?></h5>
                <p class="card-text small text-muted mb-2 flex-grow-1"><?php echo e(substr($p['descripcion'], 0, 80)); ?>...</p>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                  <strong class="text-primary fs-5">$ <?php echo number_format($p['precio'], 0, ',', '.'); ?></strong>
                  <button class="btn btn-primary btn-sm rounded-pill agregar-carrito" data-producto-id="<?php echo $p['id']; ?>">
                      <i class="bi bi-cart-plus me-1"></i>Agregar
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Paginación -->
      <?php if ($totalPaginas > 1): ?>
        <nav class="mt-5">
          <ul class="pagination justify-content-center">
            <?php for ($pnum = 1; $pnum <= $totalPaginas; $pnum++): ?>
              <li class="page-item <?= $pnum == $page ? 'active' : '' ?>">
                <a class="page-link rounded-pill mx-1" href="<?php echo baseUrl('catalogo'); ?>?q=<?php echo urlencode($q); ?>&limit=<?php echo $limit; ?>&page=<?php echo $pnum; ?>">
                  <?php echo $pnum; ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<!-- Referencias Section -->
<section id="Referencias" class="py-5 bg-light">
  <div class="container">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold text-dark mb-3">Nuestro Local</h2>
      <div class="section-subtitle">
        <span class="text-muted">Conoce</span> 
        <span class="description-title text-primary">Nuestro Espacio</span>
      </div>
    </div>

    <div class="gallery-grid" data-aos="fade-up" data-aos-delay="100">
      <div class="row g-3">
        <div class="col-6 col-md-4 col-lg-3">
          <div class="gallery-item rounded-3 overflow-hidden shadow-sm">
            <a href="<?php echo baseUrl('img/testimonials/Estilosderopa2.jpg'); ?>" class="glightbox" data-gallery="images-gallery">
              <img src="<?php echo baseUrl('img/testimonials/Estilosderopa2.jpg'); ?>" alt="Estilos de ropa" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="gallery-item rounded-3 overflow-hidden shadow-sm">
            <a href="<?php echo baseUrl('img/testimonials/Esttilosderopa3.jpeg'); ?>" class="glightbox" data-gallery="images-gallery">
              <img src="<?php echo baseUrl('img/testimonials/Esttilosderopa3.jpeg'); ?>" alt="Estilos de ropa" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="gallery-item rounded-3 overflow-hidden shadow-sm">
            <a href="<?php echo baseUrl('img/testimonials/Estilosderopa4.jpg'); ?>" class="glightbox" data-gallery="images-gallery">
              <img src="<?php echo baseUrl('img/testimonials/Estilosderopa4.jpg'); ?>" alt="Estilos de ropa" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="gallery-item rounded-3 overflow-hidden shadow-sm">
            <a href="<?php echo baseUrl('img/testimonials/estilosderopa5.jpeg'); ?>" class="glightbox" data-gallery="images-gallery">
              <img src="<?php echo baseUrl('img/testimonials/Estilosderopa6.jpg'); ?>" alt="Estilos de ropa" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="gallery-item rounded-3 overflow-hidden shadow-sm">
            <a href="<?php echo baseUrl('img/testimonials/Estilosderopa7.jpeg'); ?>" class="glightbox" data-gallery="images-gallery">
              <img src="<?php echo baseUrl('img/testimonials/Estilosderopa7.jpeg'); ?>" alt="Estilos de ropa" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="gallery-item rounded-3 overflow-hidden shadow-sm">
            <a href="<?php echo baseUrl('img/local.png'); ?>" class="glightbox" data-gallery="images-gallery">
              <img src="<?php echo baseUrl('img/local.png'); ?>" alt="Nuestro local" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="gallery-item rounded-3 overflow-hidden shadow-sm">
            <a href="<?php echo baseUrl('img/local2.png'); ?>" class="glightbox" data-gallery="images-gallery">
              <img src="<?php echo baseUrl('img/local2.png'); ?>" alt="Nuestro local" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="gallery-item rounded-3 overflow-hidden shadow-sm">
            <a href="<?php echo baseUrl('img/local3.png'); ?>" class="glightbox" data-gallery="images-gallery">
              <img src="<?php echo baseUrl('img/local3.png'); ?>" alt="Nuestro local" class="img-fluid">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sección de Equipo -->
<section id="Equipodetrabajo" class="team-section py-5 bg-white">
  <div class="container">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold text-dark mb-3">Nuestro Equipo</h2>
      <div class="section-subtitle">
        <span class="text-muted">Conoce a</span> 
        <span class="description-title text-primary">Nuestro Equipo</span>
      </div>
    </div>

    <div class="row gy-4 justify-content-center">
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="team-member text-center">
          <div class="member-photo mb-3 mx-auto rounded-circle overflow-hidden">
            <img src="<?php echo baseUrl('img/testimonials/Esteban3.jpg'); ?>" class="img-fluid" alt="Esteban Guapacha">
          </div>
          <div class="member-info">
            <h4 class="fw-bold mb-1">Esteban Guapacha</h4>
            <span class="text-primary fw-semibold">BackEND</span>
            <div class="social-links mt-3">
              <a href="https://www.instagram.com/esteban_14g?igsh=MW11YmRzZ3V5OXM1Mw==" class="social-link">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="https://www.tiktok.com/@esteban__14g?_t=ZS-8w9nqOl3dns&_r=1" class="social-link">
                <i class="bi bi-tiktok"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="team-member text-center">
          <div class="member-photo mb-3 mx-auto rounded-circle overflow-hidden">
            <img src="<?php echo baseUrl('img/testimonials/Michel3.jpg'); ?>" class="img-fluid" alt="Michel Jaramillo">
          </div>
          <div class="member-info">
            <h4 class="fw-bold mb-1">Michel Jaramillo</h4>
            <span class="text-primary fw-semibold">FrontEND</span>
            <div class="social-links mt-3">
              <a href="https://www.instagram.com/michel___1902/profilecard" class="social-link">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="https://www.tiktok.com/@michel_____19?_t=ZS-8w9nd9QRJWT&_r=1" class="social-link">
                <i class="bi bi-tiktok"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="team-member text-center">
          <div class="member-photo mb-3 mx-auto rounded-circle overflow-hidden">
            <img src="<?php echo baseUrl('img/Marianamaldonado.jpg'); ?>" class="img-fluid" alt="Mariana Maldonado">
          </div>
          <div class="member-info">
            <h4 class="fw-bold mb-1">Mariana Maldonado</h4>
            <span class="text-primary fw-semibold">Base de datos</span>
            <div class="social-links mt-3">
              <a href="https://www.instagram.com/mari_mld16/profilecard/?igsh=N3k5dHExYmR1eXFx" class="social-link">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="https://www.tiktok.com/@mari_loaiza17?_t=ZS-8w9qUOObqIE&_r=1" class="social-link">
                <i class="bi bi-tiktok"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials-section py-5 bg-primary text-white position-relative">
  <div class="testimonials-overlay position-absolute top-0 start-0 w-100 h-100"></div>
  <div class="container position-relative z-1">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold mb-3">Testimonios</h2>
      <div class="section-subtitle">
        <span>Lo que dicen</span> 
        <span class="description-title">nuestro equipo</span>
      </div>
    </div>

    <div class="row gy-4 justify-content-center">
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="testimonial-item text-center p-4 rounded-3 h-100 bg-white bg-opacity-10">
          <div class="testimonial-img mb-3 mx-auto rounded-circle overflow-hidden">
            <img src="<?php echo baseUrl('img/testimonials/Marianita.jpg'); ?>" class="img-fluid" alt="100%" height="100%">
          </div>
          <h4 class="fw-bold mb-2">Mariana</h4>
          <div class="stars mb-3">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p class="mb-0">
            <i class="bi bi-quote quote-icon-left"></i>
            Es una persona comprometida y le pone amor a las cosas que hace, es amable, responsable y honesta.
            <i class="bi bi-quote quote-icon-right"></i>
          </p>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="testimonial-item text-center p-4 rounded-3 h-100 bg-white bg-opacity-10">
          <div class="testimonial-img mb-3 mx-auto rounded-circle overflow-hidden">
            <img src="<?php echo baseUrl('img/testimonials/esteban2.jpeg'); ?>" class="img-fluid" alt="">
          </div>
          <h4 class="fw-bold mb-2">Esteban</h4>
          <div class="stars mb-3">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p class="mb-0">
            <i class="bi bi-quote quote-icon-left"></i>
            Es una persona apasionada en lo que hace, le gusta conocer gente y es muy sociable.
            <i class="bi bi-quote quote-icon-right"></i>
          </p>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="testimonial-item text-center p-4 rounded-3 h-100 bg-white bg-opacity-10">
          <div class="testimonial-img mb-3 mx-auto rounded-circle overflow-hidden">
            <img src="<?php echo baseUrl('img/testimonials/michel2.jpeg'); ?>" class="img-fluid" alt="50%" height="50%">
          </div><br>
          <h4 class="fw-bold mb-2">Michel</h4>
          <div class="stars mb-3">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p class="mb-0">
            <i class="bi bi-quote quote-icon-left"></i>
            Es una persona cariñosa y responsable, siempre está dispuesta a ayudar a los demás y es muy creativa.
            <i class="bi bi-quote quote-icon-right"></i>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Sección de Contacto -->
<section id="Contacto" class="contact-section py-5 bg-light">
  <div class="container">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold text-dark mb-3">Contáctanos</h2>
      <div class="section-subtitle">
        <span class="text-muted">Nuestro</span> 
        <span class="description-title text-primary">Contacto</span>
      </div>
    </div>

    <div class="row gy-5 gx-lg-5">
      <div class="col-lg-4">
        <div class="contact-info">
          <div class="info-item d-flex mb-4">
            <div class="info-icon flex-shrink-0 me-3">
              <i class="bi bi-geo-alt text-primary fs-4"></i>
            </div>
            <div>
              <h4 class="fw-semibold">Ubicación:</h4>
              <p class="text-muted mb-0">Medellín, Belén Miravalle</p>
            </div>
          </div>
          
          <div class="info-item d-flex mb-4">
            <div class="info-icon flex-shrink-0 me-3">
              <i class="bi bi-envelope text-primary fs-4"></i>
            </div>
            <div>
              <h4 class="fw-semibold">Correo:</h4>
              <p class="text-muted mb-0">Fashion31store@gmail.com</p>
            </div>
          </div>
          
          <div class="info-item d-flex mb-4">
            <div class="info-icon flex-shrink-0 me-3">
              <i class="bi bi-phone text-primary fs-4"></i>
            </div>
            <div>
              <h4 class="fw-semibold">Teléfono:</h4>
              <p class="text-muted mb-0">+57 3113235370</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-8">
        <div class="contact-form bg-white rounded-3 p-4 p-md-5 shadow-sm">
          <form action="<?php echo baseUrl('contacto/enviar'); ?>" method="post" role="form" class="php-email-form">
            <!-- Agregar token CSRF si lo usas -->
            <?php if (function_exists('generarTokenCSRF')): ?>
              <input type="hidden" name="csrf_token" value="<?php echo generarTokenCSRF(); ?>">
            <?php endif; ?>
            
            <div class="row">
              <div class="col-md-6 form-group mb-3">
                <input type="text" name="name" class="form-control rounded-pill" id="Nombre" placeholder="Nombre" required>
              </div>
              <div class="col-md-6 form-group mb-3">
                <input type="email" class="form-control rounded-pill" name="email" id="Correo" placeholder="Correo" required>
              </div>
            </div>
            <div class="form-group mb-3">
              <input type="text" class="form-control rounded-pill" name="Asunto" id="Asunto" placeholder="Asunto" required>
            </div>
            <div class="form-group mb-4">
              <textarea class="form-control rounded-3" name="Mensaje" rows="5" placeholder="Mensaje" required></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">Enviar Mensaje</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>