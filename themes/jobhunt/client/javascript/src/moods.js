const moods = Array.from(document.getElementsByClassName('js-moodtracker'));
const currMood = Array.from(document.getElementsByClassName('js-dayscore'))[0];

const applyMoods = (score) => {
    moods.forEach(mood => {
        let moodScore = parseInt(mood.getAttribute('data-score'));
        if (moodScore !== score) {
            mood.parentElement.classList.add('text-muted');
            mood.children[0].classList.remove('h3');
            mood.children[0].classList.add('h4');
        }
        mood.outerHTML = mood.outerHTML;
    });
}

const postMood = (mood) => {
    let score = mood.getAttribute('data-score');
    fetch('/mood', {
        method: 'POST',
        headers: {
            "x-requested-with": "XMLHttpRequest",
        },
        body: JSON.stringify({'mood': score})
    })
        .then(response => response.json())
        .then(response => {
            let score = parseInt(response['mood']);
            applyMoods(score);
        });
}
export default () => {
    if (currMood && currMood.hasAttribute('data-dayscore')) {
        let dayscore = parseInt(currMood.getAttribute('data-dayscore'));
        applyMoods(dayscore);
    }
    moods.forEach(mood => {
        mood.addEventListener('click', mood.moodHandler = () => { postMood(mood); });
    });

}
