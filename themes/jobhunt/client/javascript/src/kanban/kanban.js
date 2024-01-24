import dragula from 'dragula';

const link = `${document.href}`

export default () => {
    const drake = dragula(Array.from(document.getElementsByClassName('tasks')));
    drake.on('drop', (e, t, s) => {
        console.log(e.getAttribute('data-id'));
        console.log(document.URL.split('?')[0]);
        console.log("I'm working on this feature ")
    })
    ;
};
