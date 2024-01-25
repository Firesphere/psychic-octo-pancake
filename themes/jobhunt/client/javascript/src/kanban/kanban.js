import dragula from 'dragula';
import {addFormHook} from '../formhooks';

const myModalEl = document.getElementById('addItemModal');
const formcontainer = document.getElementById('formcontainer');
const methods = {
    'Applied': 'ApplicationForm',
    'Interview': 'InterviewForm',
    'Progress': 'StatusUpdateForm',
    'Closed': 'CloseForm'
}
const names = {
    'Applied': 'application',
    'Interview': 'interview',
    'Progress': 'statusupdate',
    'Closed': 'close'
}
let endpoint = `formhandling`

export default () => {
    const drake = dragula(Array.from(document.getElementsByClassName('tasks')),{
        revertOnSpill: true
    });
    drake.on('drop', (item, target, source) => {
        let applicationId = item.getAttribute('data-id');
        let targetId = target.getAttribute('id');
        if (targetId === source.getAttribute('id')) {
            return;
        }
        myModalEl.addEventListener('hide.bs.modal', () => {
            source.insertBefore(item, source.firstChild);
        });
        const thisendpoint = `${endpoint}/${methods[targetId]}/add/${applicationId}`
        fetch(thisendpoint, {
            headers: {
                "x-requested-with": "XMLHttpRequest",
            }
        }).then(response => response.json())
            .then(response => {
                if (response['success'] && response['form'] !== false) {
                    formcontainer.innerText = '';
                    formcontainer.insertAdjacentHTML('beforeend', response['form']);
                    tinyMCE.init({
                        selector: 'textarea.htmleditor',
                        max_height: 250,
                        menubar: false,
                        statusbar: false
                    });
                    addFormHook();
                    let button = document.getElementById('secretsauce');
                    /// Make it trigger the correct thing :D
                    button.setAttribute('data-itemtype', `${names[targetId]}-add`);
                    button.setAttribute('data-application', `${applicationId}`);
                    button.click();
                } else {
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }
            });
    });
};
