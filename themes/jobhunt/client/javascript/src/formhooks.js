const formcontainer = document.getElementById('formcontainer');
const formfooter = document.getElementById('js-submit-button');

export const updateFormContent = () => {
    formcontainer.innerHTML = '';
    formfooter.innerHTML = '';
    formcontainer.insertAdjacentHTML('beforeend', '<div></div><div class="text-center">\n' +
        '  <div class="spinner-border" role="status">\n' +
        '    <span class="visually-hidden">Loading...</span>\n' +
        '  </div>\n' +
        '</div><div></div>');
    tinyMCE.remove();
}
export const addFormHook = () => {
    let forms = Array.from(document.getElementsByTagName('form'));
    forms.forEach((form) => {
        let formId = form.getAttribute('ID');
        if (formId === "ApplicationForm_ApplicationForm") {
            let dropdown = document.getElementById('ApplicationForm_ApplicationForm_StatusID');
            let appDate = document.getElementById('ApplicationForm_ApplicationForm_ApplicationDate');
            dropdown.addEventListener('change', () => {
                let draftState = dropdown.getAttribute('data-draft')
                if (parseInt(dropdown.value) === parseInt(draftState)) {
                    appDate.removeAttribute('required');
                    appDate.removeAttribute('aria-required');
                } else {
                    appDate.setAttribute('required', 'required');
                    appDate.setAttribute('aria-required', 'true');
                }
            });
        }
        form.addEventListener('submit', (event) => {
            form = document.getElementById(form.getAttribute('id'));
            event.preventDefault();
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
                        formcontainer.innerHTML = '';
                        formfooter.innerHTML = '';
                        formcontainer.insertAdjacentHTML('beforeend', response['form']);
                        let submit = formcontainer.getElementsByClassName("btn-toolbar")[0];
                        formfooter.insertAdjacentElement('beforeend', submit);
                        let form = formcontainer.getElementsByTagName('form')[0];
                        submit.getElementsByClassName('action')[0].setAttribute('form', form.getAttribute('id'));

                        tinyMCE.init({
                            selector: 'textarea.htmleditor',
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
                        console.log(error);
                        window.location.reload();
                        throw new Error(error);
                    }, 5000);
                });
        });
    });
}
