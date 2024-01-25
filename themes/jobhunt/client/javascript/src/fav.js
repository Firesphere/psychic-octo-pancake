const favs = Array.from(document.getElementsByClassName('js-fav'));

export default () => {
    favs.forEach((fav) => {
        fav.addEventListener('click', () => {
            let icon = fav.children[0];
            let add = false;
            if (icon.classList.contains('text-warning')) {
                icon.classList.remove('text-warning');
                icon.classList.remove('bi-star-fill');
                icon.classList.add('bi-star');

            } else {
                icon.classList.add('text-warning');
                icon.classList.remove('bi-star');
                icon.classList.add('bi-star-fill');
            }
            fetch(`fav/addremove/${fav.getAttribute('data-id')}`)
        })
    })
}
