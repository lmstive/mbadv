// Atualiza o ano no rodapé
document.addEventListener('DOMContentLoaded', function() {
    const currentYearSpan = document.getElementById('currentYear');
    if (currentYearSpan) {
        currentYearSpan.textContent = new Date().getFullYear();
    }

    // Smooth scroll para links de navegação (opcional, mas bom para one-page sites)
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.hash !== "") {
                e.preventDefault();
                const hash = this.hash;
                const targetElement = document.querySelector(hash);
                if (targetElement) {
                    const navbarHeight = document.querySelector('.navbar').offsetHeight;
                    const elementPosition = targetElement.offsetTop;
                    window.scrollTo({
                        top: elementPosition - navbarHeight,
                        behavior: "smooth"
                    });

                    // Atualiza a classe 'active' no link clicado
                    navLinks.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');

                    // Fecha o menu hamburguer em mobile após o clique
                    const navbarToggler = document.querySelector('.navbar-toggler');
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarToggler.getAttribute('aria-expanded') === 'true') {
                       bootstrap.Collapse.getInstance(navbarCollapse).hide();
                    }
                }
            }
        });
    });
});