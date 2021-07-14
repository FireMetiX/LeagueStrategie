// löscht die Informations message die für den User erstellt worden ist
function displayClear(inputFeld) {
    const input = document.querySelector(inputFeld);
    const errorMessage = input.parentElement.querySelector(".valtexterror");
    input.className = '';
    
    if (errorMessage) {
        errorMessage.remove();
    };
    
}

function displayError(inputFeld, fehlerMeldung) { // inputfeld = ausgewähler Input selector, fehlerMeldung = string mit Fehlermeldung
    const input = document.querySelector(inputFeld);
    const errorMessage = input.parentElement.querySelector(".valtexterror");

    input.className = '';
    input.classList.add("valerror");

    if (errorMessage) {
        errorMessage.remove();
    };
    // Erstelle Fehlermeldung
    const meldung = document.createElement("p");
    meldung.classList.add("valtexterror");
    meldung.innerText = fehlerMeldung;
    input.parentElement.append(meldung);
    // console.log(input.parentElement);
}