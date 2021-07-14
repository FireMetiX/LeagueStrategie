// Allen Delete Buttons ein click event hinzufügen
addDeleteFunction();

function addDeleteFunction() {

    // Variabeln vorbereiten
    const allDeleteButtons = document.querySelectorAll(".guideDelete");

    allDeleteButtons.forEach(deleteBtn => {

        deleteBtn.addEventListener("click", (e) => {

            e.preventDefault();
            // Delete abfrage wird generiert
            const guidesInhalt = document.querySelector(".guidesInhalt");

            const createDiv = document.createElement("div");
            createDiv.classList.add("deleteContainer");

            const questionDiv = document.createElement("div");
            questionDiv.classList.add("deleteQuestion");

            const questionP = document.createElement("p");
            questionP.innerText = "Willst du wirklich den Guide löschen?";

            const choicesDiv = document.createElement("div");
            choicesDiv.classList.add("deleteYesNo");

            const yesP = document.createElement("p");
            yesP.classList.add("deleteJa");
            yesP.setAttribute("id", "deleteJa");
            yesP.innerText = "Ja";

            const noP = document.createElement("p");
            noP.classList.add("deleteNein");
            noP.setAttribute("id", "deleteNein");
            noP.innerText = "Nein";

            choicesDiv.appendChild(yesP);
            choicesDiv.appendChild(noP);

            questionDiv.appendChild(questionP);
            questionDiv.appendChild(choicesDiv);

            createDiv.appendChild(questionDiv);

            guidesInhalt.appendChild(createDiv);

            const yesBtn = document.querySelector(".deleteJa");
            const noBtn = document.querySelector(".deleteNein");
            const deleteContainer = document.querySelector(".deleteContainer");

            // Fragefenster mit dem klicken auf "nein" und dem Hintergrund entfernen
            noBtn.addEventListener("click", () => {
                deleteContainer.remove();
            });
            deleteContainer.addEventListener("click", () => {
                deleteContainer.remove();
            });

            // Beim klicken von "ja", wird die deleteGuide funktion aktiviert
            yesBtn.addEventListener("click", function () {
                deleteGuide(deleteBtn.dataset.guideid);
            });
        });

    });
};

function deleteGuide(guideID) { // deleteGuide funktion

     // FormData erstellen zur weitergabe von informationen
     let deleteFD = new FormData();
        
     deleteFD.append('guideID', guideID); // Guide ID anhängen
     deleteFD.append('action', 'deleteConfirm'); // action delete anhängen
     // DeleteGuide fetchen | dient hiermit nur zur überprüfung ob der User Berechtigt ist, diese aktion auszuführen
    fetch("../includes/deleteGuide.php", {
        method: 'POST',
        body: deleteFD
    })
    .then(response =>{
        response = response.text()
        .then(data =>{
            if (data == 1) { // Wenn alles okay ist (also auf "True" gesetzt ist)
                // Url überprüfen
                const queryString = window.location.search; // Get Data herbekommen
                const urlParams = new URLSearchParams(queryString);
                const page = urlParams.get('page') // Seitenzahl speichern
                const champion = urlParams.get('championSelection') // Ausgewählter Champion speichern
                const role = urlParams.get('role') // Rolle speichern
            
                // FormData für das überbringen von Daten vorbereiten
                let fd = new FormData();

                // Prüfen ob page vorhanden ist
                if(page){
                    fd.append('page', page); // Wenn der User auf einer Page ist, die nicht 1 ist, (Wenn auf der URL "page=" zu sehen ist)
                } else {
                    fd.append('page', 1); // Wenn der User sich auf Page 1 befindet
                }
                 // Prüfen ob champion vorhanden ist
                if(champion){
                    fd.append('champion', champion); // Wenn der User einen champion gefiltert hat
                } else {
                    fd.append('champion', 0); // Wenn der User KEINEN Champion gefiltert hat
                }
                // Prüfen ob champion vorhanden ist
                if(role){
                    fd.append('role', role); // Wenn der User einen champion gefiltert hat
                } else {
                    fd.append('role', "all"); // Wenn der User KEINEN Champion gefiltert hat
                }

                fetch("../includes/guidesChampionlistingRefresh.php", {
                    method: 'POST',
                    body: fd
                }) // Nach dem Löschen soll die Liste aktuallisiert werden ohne die Seite neu zu laden
                .then(response =>{
                    response = response.text() // Fetched die neu genereierte Liste im Text Format
                    .then(data => {
                        // Die aktuelle Liste mit DOM manipulation Löschen
                        const allGuides = document.querySelectorAll(".guidesContainer .guidesInhalt .guide");
                        const allGuidesEdits = document.querySelectorAll(".guidesContainer .guidesInhalt .guideUserEdit");
                        const guidesPageSelection = document.querySelector(".guidesPageSelection");
                        allGuides.forEach(guide => {
                            guide.parentElement.remove();
                        });
                        allGuidesEdits.forEach(guide => {
                            guide.remove();
                        });
                        guidesPageSelection.remove();

                        const guidesInhalt = document.querySelector(".guidesInhalt");
                        // Inhalt in einer Variable Speichern
                        const textInhalt = data;
                        // Inhalt neu befüllen
                        guidesInhalt.innerHTML += textInhalt;

                        feedback(1, "Guide wurde erfolgreich gelöscht!"); // 1 = Success
                        addDeleteFunction();

                    })
                })
            }
        })
    })
}