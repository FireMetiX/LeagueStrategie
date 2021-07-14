// Variabeln vorbereiten
const formular = document.querySelector("form");
const nachnameInputRegister = document.querySelector("#nachname");
const vornameInputRegister = document.querySelector("#vorname");
const usernameInputRegister = document.querySelector("#username");
const passwordInputRegister = document.querySelector("#password");
const emailInputRegister = document.querySelector("#email");

formular.addEventListener("submit", (e) => {

  e.preventDefault();

  let fd = new FormData();

  fd.append('nachname', nachnameInputRegister.value);
  fd.append('vorname', vornameInputRegister.value);
  fd.append('username', usernameInputRegister.value);
  fd.append('password', passwordInputRegister.value);
  fd.append('email', emailInputRegister.value);
  fd.append('submit', 'go');

  fetch("../includes/checkRegister.php", {
    method: 'POST',
    body: fd
  })
  .then( response => {
    response.json()
    .then( data => {

        if(JSON.parse(data)[0] == "success"){

          fetch("register.php", {
            method: 'POST',
            body: fd
          })
          .then(
            function() {

              const errorDiv = document.querySelector(".displayerrors");
              const successDiv = document.querySelector(".displaySuccess");

              if ( errorDiv ) {
                errorDiv.remove();
              }
              if ( successDiv ) {
                successDiv.remove();
              }

              const registerContainer = document.querySelector(".registerContainer");

              //create success message
              const successmessagediv = document.createElement("div");
              successmessagediv.classList.add("displaySuccess");
                
              successmessagediv.innerHTML = "<p>Die Registrierung war erfolgreich!</p><p>Klicke <a href='login.php'>Hier</a> um dich anzumelden!</p>";

              registerContainer.appendChild(successmessagediv);

            }
          )

        } else {

          const errorDiv = document.querySelector(".displayerrors");
          const successDiv = document.querySelector(".displaySuccess");

          if ( errorDiv ) {
            errorDiv.remove();
          }
          if ( successDiv ) {
            successDiv.remove();
          }

          const registerContainer = document.querySelector(".registerContainer");

          //create error message
          const errormessagediv = document.createElement("div");
          errormessagediv.classList.add("displayerrors");

          let errormessages = "";
          
          for (let i = 1; i < JSON.parse(data).length; i++) {
              errormessages += "<p>" + JSON.parse(data)[i] + "</p>";
            }
            
          errormessagediv.innerHTML = errormessages;

          registerContainer.appendChild(errormessagediv);
          
        }

    })

  });

})

nachnameInputRegister.addEventListener("blur", function(){
    // console.log("Blur Event");
    if (nachnameInputRegister.value == "") {
        // console.log("NAME EINGEBEN");
        displayError("#nachname", "Feld darf nicht leer sein!");
        // usernameInput.classList.add("valerror");
    } else if (nachnameInputRegister.value.length > 50) {
        displayError("#nachname", "Feld hat mehr als 50 Zeichen!");
    } else {
        displayClear("#nachname");
    };
});

vornameInputRegister.addEventListener("blur", function(){
    // console.log("Blur Event");
    if (vornameInputRegister.value == "") {
        // console.log("NAME EINGEBEN");
        displayError("#vorname", "Feld darf nicht leer sein!");
        // usernameInput.classList.add("valerror");
    } else if (vornameInputRegister.value.length > 50) {
        displayError("#vorname", "Feld hat mehr als 50 Zeichen!");
    } else {
        displayClear("#vorname");
    };
});

usernameInputRegister.addEventListener("blur", function(){
    // console.log("Blur Event");
    if (usernameInputRegister.value == "") {
        // console.log("NAME EINGEBEN");
        displayError("#username", "Feld darf nicht leer sein!");
        // usernameInput.classList.add("valerror");
    } else if (usernameInputRegister.value.length > 50) {
        displayError("#username", "Feld hat mehr als 50 Zeichen!");
    } else {
        displayClear("#username");
    };
});

passwordInputRegister.addEventListener("blur", function(){
    // console.log("Blur Event");
    if (passwordInputRegister.value == "") {
        // console.log("NAME EINGEBEN");
        displayError("#password", "Feld darf nicht leer sein!");
        // usernameInput.classList.add("valerror");
    } else {
        displayClear("#password");
    };
});

emailInputRegister.addEventListener("blur", function(){

    let emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    // console.log("Blur Event");
    if (emailInputRegister.value == "") {
        // console.log("NAME EINGEBEN");
        displayError("#email", "Feld darf nicht leer sein!");
        // usernameInput.classList.add("valerror");
    } else if (!emailRegExp.test(emailInputRegister.value)) {
        displayError("#email", "Keine richtige Email eingegeben!");
    } else {
        displayClear("#email");
    };
});

