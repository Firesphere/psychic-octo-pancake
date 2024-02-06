const showClick = document.getElementsByClassName('showOnClick')[0]
const container = document.getElementsByClassName('showOnClickContainer')[0];
export default function () {
    if (showClick) {
        const link = showClick.querySelectorAll('a')[0];
        if (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                let classes = container.classList;
                classes.toggle('d-none');
            });
        }
    }
}
