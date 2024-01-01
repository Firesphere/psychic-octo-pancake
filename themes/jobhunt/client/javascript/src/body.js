const navbarCollapsible = document.getElementById('mainNav');

const navbarShrink = () => {
    if (window.scrollY <= 10) {
        navbarCollapsible.classList.remove('navbar-shrink');
    } else {
        navbarCollapsible.classList.add('navbar-shrink');
    }
}
export default () => {
    if (navigator.getEnvironmentIntegrity !== undefined) {
        document.querySelector('body').innerHTML = '<div class="container"><h1>Your browser contains Google DRM</h1>"Web Environment Integrity" is a Google euphemism for a DRM that is designed to prevent ad-blocking. In support of an open web, this website does not function with this DRM. Please install a browser such as <a href="https://www.mozilla.org/en-US/firefox/new/">Firefox</a> that respects your freedom and supports ad blockers.</div>';
    }
    if (navbarCollapsible) {
        navbarShrink();
        document.addEventListener('scroll', navbarShrink);
    }
}
