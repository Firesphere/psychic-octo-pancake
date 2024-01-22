const tagFields = Array.from(document.getElementsByTagName('bs-tags'));

export default () => {
    tagFields.forEach(field => {
        field.addEventListener('change', () => {

        })
    })
}
