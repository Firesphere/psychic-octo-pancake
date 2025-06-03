const formcontainer = document.getElementById('formcontainer');
const formfooter = document.getElementById('js-submit-button');

export const updateFormContent = () => {
    formcontainer.innerHTML = '';
    formfooter.innerHTML = '';
    formcontainer.insertAdjacentHTML('beforeend', '<div class="text-center">\n' +
        '  <div class="spinner-border" role="status">\n' +
        '    <span class="visually-hidden">Loading...</span>\n' +
        '  </div>\n' +
        '</div>');
    tinyMCE.remove();
}
export const addFormHook = () => {
    let forms = Array.from(document.getElementsByTagName('form'));
    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
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
                            max_height: 250,
                            menubar: false,
                            statusbar: false
                        });
                        addFormHook();
                    } else {
                        updateFormContent();
                        setTimeout(() => {
                            console.log('reloading');
                            window.location.reload();
                        }, 500);
                    }
                })
                .catch((error) => {
                    formcontainer.innerText = "It seems something went wrong. Please try again?";
                    setTimeout(() => {
                        console.log('reloading');
                        window.location.reload();
                        throw new Error(error);
                    }, 5000);
                });
        });
    });
}
