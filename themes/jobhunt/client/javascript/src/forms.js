const actions = Array.from(document.getElementsByClassName('js-formaction'));
const formcontainer = document.getElementById('formcontainer');
const endpoint = 'formhandling/'
const typemap = {
    'application': 'ApplicationForm',
    'note': 'NoteForm',
    'interview': 'InterviewForm',
    'statusupdate': 'StatusUpdateForm'
}

const updateFormContent = () => {
    formcontainer.innerHTML = '';
    formcontainer.insertAdjacentHTML('beforeend', '<div class="text-center">\n' +
        '  <div class="spinner-border" role="status">\n' +
        '    <span class="visually-hidden">Loading...</span>\n' +
        '  </div>\n' +
        '</div>');
    tinyMCE.remove();
}
export default () => {
    const myModalEl = document.getElementById('addItemModal')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        updateFormContent();
        tinyMCE.remove();
    });

    actions.forEach(action => {
        action.addEventListener('click', () => {
            let type = action.getAttribute('data-itemtype').split('-');
            let url = `${endpoint}${typemap[type[0]]}`;
            let id = 0;
            if (type.length > 1) {
                if (type[1] === 'add') {
                    id = action.getAttribute('data-application')
                }
                if (type[1] === 'edit') {
                    id = action.getAttribute('data-id');
                }
                url = `${url}/${type[1]}/${id}`
            }
            updateFormContent();

            fetch(url, {
                method: 'GET',
                headers: {
                    "x-requested-with": "XMLHttpRequest",
                }
            })
                .then(response => response.json())
                .then(response => {
                    formcontainer.innerHTML = '';
                    if (response['success'] && response['form'] !== false) {
                        formcontainer.insertAdjacentHTML('beforeend', response['form']);
                        tinyMCE.init({
                            selector: 'textarea.htmleditor',
                            skin: 'silverstripe',
                            max_height: 250,
                            menubar: false,
                            statusbar: false
                        });

                        addFormHook();
                    } else {
                        updateFormContent();
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000)
                    }
                });
        });
    });
}

const addFormHook = () => {
    let forms = Array.from(document.getElementsByTagName('form'));
    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            updateFormContent();
            event.preventDefault();
            form.children.find
            let formData = new FormData(form);
            updateFormContent();
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    "x-requested-with": "XMLHttpRequest",
                }
            })
                .then(response => response.json())
                .then(response => {
                    if (response['success'] !== false && response['form'] !== false) {
                        formcontainer.innerText = '';
                        formcontainer.insertAdjacentHTML('beforeend', response['form']);
                        tinyMCE.init({
                            selector: 'textarea.htmleditor',
                            skin: 'silverstripe',
                            max_height: 250,
                            menubar: false,
                            statusbar: false
                        });
                        addFormHook();
                    } else {
                        updateFormContent();
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    }
                })
                .catch((error) => {
                    formcontainer.innerText = "It seems something went wrong. Please try again?";
                    setTimeout(() => {
                        window.location.reload();
                        throw new Error(error);
                    }, 5000);
                });
        });
    });
}
