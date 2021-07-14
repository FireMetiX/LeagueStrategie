
function feedback(reaction, message){
    if(reaction == 0){ // Wenn der Feedback ein ERROR ist
        // Error Message erstellen
        const mainContainer = document.querySelector(".main");
        const createDiv = document.createElement("div");
        createDiv.classList.add("errorContainer");
        createDiv.innerHTML = "<p>" + message + "</p>"
        mainContainer.appendChild(createDiv);

        // Feedback animation vorbereiten
        const errorContainer = document.querySelector(".errorContainer");
        // Greensock vorbereiten
        const openingtimeline = gsap.timeline();

        openingtimeline.to(errorContainer,{
            duration: 0.5,
            autoAlpha: 1,
            y: 20
        })
        .to(errorContainer,{
            delay: 2,
            duration: 0.5,
            y: -20,
            autoAlpha: 0,
            onComplete() {
                // Message entfernen
                const allErrorContainers = document.querySelectorAll(".errorContainer");
                allErrorContainers.forEach(message => {
                    message.remove();
                });
            }
        })
    } else { // Wenn der Feedback ein SUCCESS ist
        // Success Message erstellen
        const mainContainer = document.querySelector(".main");
        const createDiv = document.createElement("div");
        createDiv.classList.add("successContainer");
        createDiv.innerHTML = "<p>" + message + "</p>"
        mainContainer.appendChild(createDiv);

        // Feedback animation vorbereiten
        const successContainer = document.querySelector(".successContainer");
        // Greensock vorbereiten
        const openingtimeline = gsap.timeline();

        openingtimeline.to(successContainer,{
            duration: 0.5,
            autoAlpha: 1,
            y: 20
        })
        .to(successContainer,{
            delay: 2,
            duration: 0.5,
            y: -20,
            autoAlpha: 0,
            onComplete() {
                // Message entfernen
                const allSuccessContainers = document.querySelectorAll(".successContainer");
                allSuccessContainers.forEach(message => {
                    message.remove();
                });
            }
        })
    }
}