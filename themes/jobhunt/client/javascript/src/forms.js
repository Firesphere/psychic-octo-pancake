let actions = Array.from(document.getElementsByClassName('js-formaction'));
const formcontainer = document.getElementById('formcontainer');
const formfooter = document.getElementById('js-submit-button');
const myModalEl = document.getElementById('addItemModal');
const actionTypeSpan = document.getElementById('modal-item-type');
const actionTitleSpan = document.getElementById('modal-item-title');
import {addFormHook, updateFormContent} from './formhooks';

const endpoint = 'formhandling/'
const typemap = {
    'application': [
        'ApplicationForm',
        'application'
    ],
    'note': [
        'ApplicationNoteForm',
        'note'
    ],
    'interview': [
        'InterviewForm',
        'interview'
    ],
    'interviewnote': [
        'InterviewNoteForm',
        'interview note'
    ],
    'postinterview': [
        'PostInterview',
        'status update'
    ],
    'statusupdate': [
        'StatusUpdateForm',
        'status update'
    ],
    'import': [
        'ImportForm',
        'import'
    ],
    'company': [
        'CompanyForm',
        'company'
    ],
    'companynote': [
        'CompanyNoteForm',
        'Company note'
    ],
    'close': [
        'CloseForm',
        'close application'
    ]
}


export default () => {
    bindActions(actions);
    myModalEl.addEventListener('hidden.bs.modal', event => {
        updateFormContent();
    });

    myModalEl.addEventListener('shown.bs.modal', event => {
        let cardlist = Array.from(document.getElementsByClassName('js-formaction card-link'));
        bindActions(cardlist);
    });

}

const bindActions = (list) => {
    list.forEach(action => {
        action.addEventListener('click', (e) => {
            e.preventDefault();
            let type = action.getAttribute('data-itemtype').split('-');
            let url = `${endpoint}${typemap[type[0]][0]}`;
            let id = 0;
            if (type.length > 1) {
                if (type[1] === 'add') {
                    id = action.getAttribute('data-application');
                    actionTypeSpan.innerText = 'Add';
                }
                if (type[1] === 'edit') {
                    id = action.getAttribute('data-id');
                    actionTypeSpan.innerText = 'Edit'
                }
                actionTitleSpan.innerText = typemap[type[0]][1];
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
                    if (response['success'] && response['form'] !== false) {
                        formcontainer.innerHTML = '';
                        formfooter.innerHTML = '';
                        formcontainer.innerHTML = response['form'];
                        let submit = formcontainer.getElementsByClassName("btn-toolbar")[0];
                        formfooter.insertAdjacentElement('beforeend', submit);
                        let form = formcontainer.getElementsByTagName('form')[0];
                        submit.getElementsByClassName('action')[0].setAttribute('form', form.getAttribute('id'));
                        tinyMCE.init({
                            selector: '#formcontainer textarea.htmleditor',
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
                })
                .catch(response => {
                    if (response.status !== 200) {
                        console.warn(response);
                        formcontainer.innerText = "It seems something went wrong. Are you logged in?";
                    }
                });
        });
    });
}
