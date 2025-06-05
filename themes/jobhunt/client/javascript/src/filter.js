const filters = [
    document.getElementById('show_rolefilter'),
    document.getElementById('show_companyfilter')
];
const filterInputs = [
    document.getElementById('rolefilter'),
    document.getElementById('companyfilter')
];
const filterclears = [
    document.getElementById('clear_companyfilter'),
    document.getElementById('clear_rolefilter'),
];
const tablebody = document.getElementById('applicationtable_body');
let timer;
const searchResult = (field) => {
    let searchValue = field.value;
    let searchType = field.getAttribute('id');
    let data = new FormData();
    data.append('search', searchValue);
    data.append('type', searchType);

    fetch('/applicationfilter', {
        method: 'POST',
        body: data,
        headers: {
            "x-requested-with": "XMLHttpRequest",
        }
    })
        .then(response => response.json())
        .then(response => {
            tablebody.innerHTML = '';
            timer = setTimeout(() => {

                tablebody.insertAdjacentHTML('beforeend', response['result']);
                Array.from(document.getElementsByClassName('pagination')).forEach(paginator => {
                    paginator.remove();
                });
            }, 50);
        });
}
export default () => {
    if (filterclears.length > 0 && filterclears[0]) {
        filterclears.forEach(clearer => {
            clearer.addEventListener('click', e => {
                e.preventDefault();
                let elmId = clearer.getAttribute('id').split('_');
                document.getElementById(elmId[1]).value = '';
                clearer.setAttribute('disabled', 'disabled');
                document.location.reload();
            })
        });
    }
    if (filters.length > 0 && filters[0]) {
        filters.forEach(element => {
            element.addEventListener('click', (event) => {
                event.preventDefault();
                let elmId = element.getAttribute('id').split('_');
                document.getElementById(`${elmId[1]}_group`).classList.toggle('d-none');
                element.classList.toggle('bi-funnel-fill');
                element.classList.toggle('bi-funnel');
            });
        });
    }
    if (filterInputs.length > 0 && filterInputs[0]) {
        filterInputs.forEach(field => {
            field.addEventListener('keyup', () => {
                if (typeof timer !== 'undefined') {
                    window.clearTimeout(timer);
                }
                tablebody.innerHTML = '';
                tablebody.insertAdjacentHTML('beforeend',
                    '\n' +
                    '  <div class="d-flex justify-content-center p-3 m-3"><div class="spinner-border" role="status">\n' +
                    '    <span class="visually-hidden">Loading...</span>\n' +
                    '  </div></div>');
                if (field.value !== '') {
                    searchResult(field)
                } else {
                    timer = setTimeout(() => {
                        window.location.reload();
                    }, 150)
                }
            });
        });
    }
}
