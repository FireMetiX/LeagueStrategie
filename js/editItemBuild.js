// Variabeln vorbereiten
const itemSetsWrapper = document.querySelector('.itemSetsWrapper');
const allSets = document.querySelectorAll('.sets');

// Prüfen, ob schon sets vorhanden sind
if (allSets.length == 0) {
    setAvaiable = false;
    addToSet.innerHTML = "Create a set first";
} else {
    setAvaiable = true;
    addToSet.innerHTML = "Add to set";
}

// Führt addDeletefunktion funktion aus
addDeletefunktion();

onlyRefreshClickEventsLis();

triggerSortierung();