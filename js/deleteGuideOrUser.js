// allen Delete Buttons der Guides ein click event hinzufügen
addDeleteFunction();

function addDeleteFunction() {

    // Variabeln vorbereiten
    const allDeleteButtons = document.querySelectorAll(".guideDelete");

    allDeleteButtons.forEach(deleteBtn => {

        deleteBtn.addEventListener("click", (e) => {

            e.preventDefault();

            // Delete abfrage wird generiert
            const latestRegistrationsContainer = document.querySelector(".latestRegistrationsContainer");

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

            latestRegistrationsContainer.appendChild(createDiv);

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

// allen Delete Buttons der Users ein click event hinzufügen
addDeleteFunctionUsers();

function addDeleteFunctionUsers() {

    // Variabeln vorbereiten
    const allDeleteButtons = document.querySelectorAll(".userDelete");

    allDeleteButtons.forEach(deleteBtn => {

        deleteBtn.addEventListener("click", (e) => {

            e.preventDefault();

            // Delete abfrage wird generiert
            const latestRegistrationsContainer = document.querySelector(".latestRegistrationsContainer");

            const createDiv = document.createElement("div");
            createDiv.classList.add("deleteContainer");

            const questionDiv = document.createElement("div");
            questionDiv.classList.add("deleteQuestion");

            const questionP = document.createElement("p");
            questionP.innerText = "Willst du wirklich den User löschen?";

            const questionHinweis = document.createElement("p");
            questionHinweis.innerText = "Alle vom User erstellten Guides werden auch gelöscht!";

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
            questionDiv.appendChild(questionHinweis);
            questionDiv.appendChild(choicesDiv);

            createDiv.appendChild(questionDiv);

            latestRegistrationsContainer.appendChild(createDiv);

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
                deleteUser(deleteBtn.dataset.userid);
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
                fetch("../includes/admindashboardReturnList.php") // Nach dem Löschen soll die Liste aktuallisiert werden ohne die Seite neu zu laden
                .then(response =>{
                    response = response.text() // Fetched die neu genereierte Liste im Text Format
                    .then(data => {
                        // Die aktuelle Liste mit DOM manipulation Löschen
                        const adminSection = document.querySelector(".admin");
                        // const allGuides = document.querySelectorAll(".latestGuidesContainer .guide");
                        // const allGuidesEdits = document.querySelectorAll(".latestGuidesContainer .guideUserEdit");

                        adminSection.remove();

                        const mainSection = document.querySelector(".main");
                        // Inhalt in einer Variable Speichern
                        const siteInhalt = data;
                        // Inhalt neu befüllen
                        mainSection.innerHTML += siteInhalt;

                        feedback(1, "Guide wurde erfolgreich gelöscht!"); // 1 = Success
                        addDeleteFunction();
                        addDeleteFunctionUsers();

                    })
                })
            }
        })
    })
}

function deleteUser(userID) { // deleteGuide funktion

    // FormData erstellen zur weitergabe von informationen
    let deleteFD = new FormData();
       
    deleteFD.append('userID', userID); // User ID anhängen
    deleteFD.append('action', 'deleteConfirm'); // action delete anhängen
    // DeleteGuide fetchen | dient hiermit nur zur überprüfung ob der User Berechtigt ist, diese aktion auszuführen
   fetch("../includes/deleteUser.php", {
       method: 'POST',
       body: deleteFD
   })
   .then(response =>{
       response = response.text()
       .then(data =>{
           if (data == 1) { // Wenn alles okay ist (also auf "True" gesetzt ist)
               fetch("../includes/admindashboardReturnList.php") // Nach dem Löschen soll die Liste aktuallisiert werden ohne die Seite neu zu laden
               .then(response =>{
                   response = response.text() // Fetched die neu genereierte Liste im Text Format
                   .then(data => {
                       // Die aktuelle Liste mit DOM manipulation Löschen
                       const adminSection = document.querySelector(".admin");
                       // const allGuides = document.querySelectorAll(".latestGuidesContainer .guide");
                       // const allGuidesEdits = document.querySelectorAll(".latestGuidesContainer .guideUserEdit");

                       adminSection.remove();

                       const mainSection = document.querySelector(".main");
                       // Inhalt in einer Variable Speichern
                       const siteInhalt = data;
                       // Inhalt neu befüllen
                       mainSection.innerHTML += siteInhalt;

                       feedback(1, "Der User wurde erfolgreich gelöscht!"); // 1 = Success
                       addDeleteFunction();
                       addDeleteFunctionUsers();

                   })
               })
           }
       })
   })
}