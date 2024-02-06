const favs = Array.from(document.getElementsByClassName('js-fav'));

export default () => {
    favs.forEach((fav) => {
        fav.addEventListener('click', event => {
            event.preventDefault();
            let icon = fav.children[0];
            let add = false;
            icon.classList.toggle('text-warning');
            icon.classList.toggle('bi-star-fill');
            icon.classList.toggle('bi-star');
            fetch(`fav/addremove/${fav.getAttribute('data-id')}`)
        });
    });
}
