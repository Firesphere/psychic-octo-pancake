import dragula from 'dragula';

const myModalEl = document.getElementById('addItemModal');
const names = {
    'Applied': 'application',
    'Interview': 'interview',
    'Progress': 'statusupdate',
    'Closed': 'close',
    'Follow': 'postinterview',
    'PostInterview': 'postinterview'
}
const disallowedJumps = {
    'Applied': ['AlwaysInvalidForHardening', 'Follow', 'PostInterview'],
    'Progress': ['AlwaysInvalidForHardening', 'Follow', 'PostInterview'],
}

export default () => {
    const drake = dragula(Array.from(document.getElementsByClassName('tasks')), {
        revertOnSpill: true
    });
    drake.on('drop', (item, target, source) => {
        let applicationId = item.getAttribute('data-id');
        let targetId = target.getAttribute('id');
        let sourceId = source.getAttribute('id');
        if (targetId === sourceId) {
            return;
        }
        // Not-allowed jumps
        if (disallowedJumps[sourceId] && disallowedJumps[sourceId].indexOf(targetId) !== false) {
            source.insertBefore(item, source.firstChild);
        } else {
            myModalEl.addEventListener('hide.bs.modal', () => {
                source.insertBefore(item, source.firstChild);
            });

            let button = document.getElementById('secretsauce');
            /// Make it trigger the correct thing :D
            button.setAttribute('data-itemtype', `${names[targetId]}-add`);
            button.setAttribute('data-application', `${applicationId}`);
            button.click();
        }

    });
};
