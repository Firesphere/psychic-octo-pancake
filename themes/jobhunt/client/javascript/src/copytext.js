const copylinks = Array.from(document.getElementsByClassName('js-copytext'));

export default () => {
    copylinks.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            let text = item.getAttribute('href');
            navigator.clipboard.writeText(text)
                .then(() => {
                    let icon = item.querySelector('i.js-copytext-icon');
                    icon.classList.remove('bi-clipboard-pulse');
                    icon.classList.add('bi-clipboard-check');
                    icon.classList.add('bg-success');
                    setTimeout(() => {
                        icon.classList.remove('bg-success');
                    }, 500)
                });
        })
    })
}
