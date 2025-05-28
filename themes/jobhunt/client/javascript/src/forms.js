let actions = Array.from(document.getElementsByClassName('js-formaction'));
const formcontainer = document.getElementById('formcontainer');
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
                .then(response => {
                    console.log(response)

                })
                .then(response => response.json())
                .then(response => {
                    formcontainer.innerHTML = '';
                    if (response['success'] && response['form'] !== false) {
                        formcontainer.insertAdjacentHTML('beforeend', response['form']);
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
                .catch(() => {
                    formcontainer.innerText = "It seems something went wrong. Are you logged in?";
                });
        });
    });
}
