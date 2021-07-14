// Variabeln vorbereiten
const formular = document.querySelector("form");
const usernameInputLogin = document.querySelector("#username");
const passwordInput = document.querySelector("#password");

formular.addEventListener("submit", (e) => {
  e.preventDefault();
  let fd = new FormData();

  fd.append('username', usernameInputLogin.value);
  fd.append('password', passwordInput.value);
  fd.append('submit', 'go');

  fetch("../includes/checkLogin.php", {
    method: 'POST',
    body: fd
  })
  .then( response => {
    response.json()
    .then( data => {
        // console.log(JSON.parse(data));
        if(JSON.parse(data)[0] == "success"){

          fetch("login.php", {
            method: 'POST',
            body: fd
          })
          .then(
            function() {
              window.location.href = '../index.php'; // Auf Index.php weiterleiten wenn alles geklappt hat
            }
          )

        } else {

          const errorDiv = document.querySelector(".displayerrors"); // Prüft, ob sich schon ein displayerrors container auf der Page befindet
          if ( errorDiv ) {
            errorDiv.remove(); // Löscht den sich noch im Page befindenen displayerrors container
          }
          const loginContainer = document.querySelector(".loginContainer");

          //create error message
          const errormessagediv = document.createElement("div");
          errormessagediv.classList.add("displayerrors");

          const errormessages = document.createElement("p");
          errormessages.innerText = JSON.parse(data)[1];

          errormessagediv.appendChild(errormessages);

          loginContainer.appendChild(errormessagediv);
          
        }

    })

  });

})

usernameInputLogin.addEventListener("blur", function(){
    // console.log("Blur Event");
    if (usernameInputLogin.value == "") {
        // console.log("NAME EINGEBEN");
        displayError("#username", "Feld darf nicht leer sein!");
        // usernameInput.classList.add("valerror");
    } else if (usernameInputLogin.value.length > 50) {
        displayError("#username", "Feld hat mehr als 50 Zeichen!");
    } else {
        displayClear("#username");
    };
})