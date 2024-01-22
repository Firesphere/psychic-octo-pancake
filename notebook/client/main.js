const notes = Array.from(document.getElementsByClassName('js-notebook-edit'))
const form = document.getElementById('NotebookForm_NotebookForm');

const initNotes = () => {
    if (notes.length) {
        notes.forEach(editlink => {
            editlink.addEventListener('click', (e) => {
                e.preventDefault();
                let id = editlink.getAttribute('href').replace('/#', '');
                let title = document.getElementById(`note-${id}-title`).innerText;
                let content = document.getElementById(`note-${id}-content`).innerHTML;
                document.getElementById('NotebookForm_NotebookForm_ID').value = id;
                document.getElementById('NotebookForm_NotebookForm_Title').value = title;
                document.getElementById('NotebookForm_NotebookForm_Content').value = content;
                document.getElementById('notebookFormToggle').dispatchEvent(new Event('click'));
            });
        });
    }
    if (form.length) {
        form.addEventListener('show.bs.collapse', event => {
            tinyMCE.remove();
            tinyMCE.init({
                selector: '#offcanvasNotes form textarea.htmleditor',
                max_height: 175,
                menubar: false,
                statusbar: false
            });
        });
        form.addEventListener('hidden.bs.collapse', () => {
            tinyMCE.remove();
            document.getElementById('NotebookForm_NotebookForm_ID').value = '';
            document.getElementById('NotebookForm_NotebookForm_Title').value = '';
            document.getElementById('NotebookForm_NotebookForm_Content').value = '';
        });
    }
}

initNotes();
