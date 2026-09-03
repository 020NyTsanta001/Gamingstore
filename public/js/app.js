// ==========================================================================
// Script unique et volontairement simple : pas de framework JS, juste le
// nécessaire pour les 3 comportements demandés :
//   1) carousel de 4 photos qui change toutes les 4s
//   2) overlay "card agrandie" quand on clique un produit
//   3) petite ombre sur la navbar sticky au scroll
// ==========================================================================

document.addEventListener('DOMContentLoaded', () => {

  // 1) Carousel intro (4 images, alternance toutes les 4 secondes)
  const slides = document.querySelectorAll('.intro-carousel-img');
  if (slides.length) {
    let current = 0;
    setInterval(() => {
      slides[current].classList.remove('active');
      current = (current + 1) % slides.length;
      slides[current].classList.add('active');
    }, 4000);
  }

  // 2) Overlay produit : chaque .product-card ouvre l'overlay correspondant
  document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('click', (e) => {
      // Ne pas ouvrir l'overlay si on a cliqué le bouton "ajouter au panier"
      if (e.target.closest('.js-add-to-cart')) return;

      const overlay = document.getElementById(card.dataset.overlayTarget);
      if (overlay) overlay.classList.add('open');
    });
  });

  document.querySelectorAll('.overlay-close, .product-overlay').forEach(el => {
    el.addEventListener('click', (e) => {
      // ferme seulement si on clique le fond ou le bouton X, pas la card elle-même
      if (e.target.classList.contains('product-overlay') || e.target.closest('.overlay-close')) {
        e.target.closest('.product-overlay')?.classList.remove('open');
      }
    });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.product-overlay.open').forEach(o => o.classList.remove('open'));
    }
  });

  // 3) Ombre navbar au scroll
  const navbar = document.querySelector('.navbar-gaming');
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.style.boxShadow = window.scrollY > 20 ? '0 6px 20px rgba(0,0,0,.35)' : 'none';
    });
  }
});
