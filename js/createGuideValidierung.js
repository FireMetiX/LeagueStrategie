// Selectoren vorbereiten
const formular = document.querySelector("form");

// Klick event auf das Formular vorbereiten
formular.addEventListener("submit", (e) => {
    e.preventDefault(); // verhindert, dass die Seite neu geladen wird
    let fd = new FormData(formular); // Erstelle neue Formdata
    const submitButton = document.querySelector('input[type="submit"]'); // Query Selector für den Submit Button

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const guideParams = urlParams.get('guide');
    if(guideParams != null){
      fd.append('guideID', guideParams);
    }

    fd.append('editor1', CKEDITOR.instances['editor1'].getData());
    fd.append('submit', submitButton.value);
  
    fetch("../includes/checkGuide.php", {
      method: 'POST',
      body: fd
    })
    .then( response => {
      response.json()
      .then( data => {

        if(data[0] == "Success"){ // Wenn der erste Inhalt im Array "Success" ist
          fetch("../includes/createGuideCreateOrEditGuide.php", {
            method: 'POST',
            body: fd
          })
          .then( function () {

            const errorDiv = document.querySelector(".displayerrors"); // Prüft, ob sich schon ein displayerrors container auf der Page befindet
            if ( errorDiv ) {
              errorDiv.remove(); // Löscht den sich noch im Page befindenen displayerrors container
            }

            feedback(1, "Guide wurde erfolgreich erstellt!"); // 1 = Success
          })

        } else { // Wenn der erste Inhalt im Array "Error" ist
          feedback(0, "Ein Fehler ist aufgetreten!"); // 0 = Error
          const createGuideContainer = document.querySelector(".createGuideContainer"); // Query Selector für das einfügen der Fehler

          const errorDiv = document.querySelector(".displayerrors"); // Prüft, ob sich schon ein displayerrors container auf der Page befindet

          if ( errorDiv ) {
            errorDiv.remove(); // Löscht den sich noch im Page befindenen displayerrors container
          }

          const createErrorDiv = document.createElement("div");
          createErrorDiv.classList.add("displayerrors");
          let errorMessages = "";
          for (let i = 1; i < data.length; i++) {
            errorMessages += "<p>" + data[i] + "</p>";
          }
          createErrorDiv.innerHTML = errorMessages;
          createGuideContainer.appendChild(createErrorDiv);
        }

      })
    });

});