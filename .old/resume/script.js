let flipped = false;

function toggleFlip() {
    const flipper = document.getElementById('flipper');
    if (flipped) {
        flipper.style.transform = 'rotateY(0deg)';
        flipped = false;
    } else {
        flipper.style.transform = 'rotateY(180deg)';
        flipped = true;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    var header = document.getElementById("header");
    var phrase = document.getElementById("phrase");

    header.classList.remove("hidden");
    header.classList.add("visible");

    header.addEventListener("animationend", function() {
        phrase.classList.add("phrase-visible");
    });
});
