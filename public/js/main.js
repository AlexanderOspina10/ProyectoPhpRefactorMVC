const scrollToTopButton = document.createElement('button');
scrollToTopButton.className = 'scroll-to-top';
scrollToTopButton.innerHTML = '<i class="bi bi-chevron-up"></i>';
scrollToTopButton.setAttribute('aria-label', 'Volver arriba');
document.body.appendChild(scrollToTopButton);

// Mostrar/ocultar botón al hacer scroll
window.addEventListener('scroll', () => {
  if (window.pageYOffset > 300) {
    scrollToTopButton.classList.add('show');
  } else {
    scrollToTopButton.classList.remove('show');
  }
});

// Función para volver arriba
scrollToTopButton.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});

// Efecto de aparición suave para elementos del footer
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.animationPlayState = 'running';
    }
  });
}, observerOptions);

// Observar elementos del footer
document.addEventListener('DOMContentLoaded', () => {
  const footerItems = document.querySelectorAll('.footer-item');
  footerItems.forEach(item => {
    item.style.animationPlayState = 'paused';
    observer.observe(item);
  });
});

document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.header');
    
    function updateHeaderOnScroll() {
        if (window.scrollY > 20) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
    
    // Initial check
    updateHeaderOnScroll();
    
    // Listen to scroll events with throttling
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(function() {
                updateHeaderOnScroll();
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Close mobile menu when clicking on a link
    const mobileMenuLinks = document.querySelectorAll('#mobileMenu a');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu.classList.contains('show')) {
                bootstrap.Collapse.getInstance(mobileMenu).hide();
            }
        });
    });

    // Mejorar la experiencia del dropdown
    const profileDropdown = document.getElementById('perfilMenu');
    if (profileDropdown) {
        profileDropdown.addEventListener('shown.bs.dropdown', function () {
            this.classList.add('show');
        });
        
        profileDropdown.addEventListener('hidden.bs.dropdown', function () {
            this.classList.remove('show');
        });
    }
});



