import {updateFormContent} from "./formhooks";

const tagFields = Array.from(document.getElementsByClassName('bstags'));

export default () => {
    tagFields.forEach((field) => {
        field.addEventListener('change', () => {
            console.log('hello');
            let formData = new FormData(field.form);
            fetch(field.form.action, {
                method: field.form.method,
                body: formData,
                headers: {
                    "x-requested-with": "XMLHttpRequest",
                }
            }).then(() => {
                //no-op
                return;
            })
        })
    })
}
