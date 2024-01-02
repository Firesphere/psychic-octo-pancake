const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => {
    console.log(popoverTriggerEl);
    new bootstrap.Popover(popoverTriggerEl)
});
