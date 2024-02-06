const input = document.getElementById('filter');
const contents = Array.from(document.getElementsByClassName('quickfilter'));
const roles = Array.from(document.getElementsByClassName('quickfilter-role'));

const doFilter = (element, noAdd) => {
    let value = input.value.toLowerCase();
    let dataId = element.getAttribute('data-appid');
    let card = document.getElementById(`application-${dataId}`);
    let txtValue = element.textContent || element.innerText;
    if (txtValue.toLowerCase().indexOf(value) !== -1) {
        card.classList.remove('d-none');
    } else if (!noAdd) {
        card.classList.add('d-none');
    }
}
export default () => {
    input.addEventListener('keyup', () => {
        setTimeout(() => {
            contents.forEach(element => {
                doFilter(element, false);
            });
            roles.forEach(element => {
                doFilter(element, true );
            });

        }, 500);
    })
}
