// Variabeln für die Selectoren vorbereiten
const addNewSetButton = document.querySelector('.addSet');
const itemSetContainer = document.querySelector('.itemSetsWrapper');
const addToSet = document.querySelector('.addToSetButton');
const addToSetContainer = document.querySelector('.addToSetBG');
const addToSetUl = document.querySelector('.addToSetBG ul');
const itemFilterList = document.querySelectorAll('.itemsFilter ul li');

// Allgemeine Variabeln vorbereiten 
let selectedFilters = ["All"];
let loadLIMenu = false;
let setAvaiable = false;


// führt die funktion aus um alle Items im shop anzuzeigen
listItemsInShop();

// Füge jedem Filter ein klick event zu
itemFilterList.forEach(filter => {
    filter.addEventListener('click', changeItemFilter);
});

// Click event für die Funktion addNewSet hinzufügen
addNewSetButton.addEventListener('click', function () {
    addToSet.innerHTML = "Add to set";
    const allSets = document.querySelectorAll('.itemSetsWrapper .sets');
    if (allSets.length == 9) {
        feedback(0, "Maximal 9 Sets möglich!") // Error meldung mit feedback funktion
    } else {
        addANewLi(); // Führt funktion addANewLi aus
    }
});

// Click event für die Funktion addToSetfunction hinzufügen
addToSet.addEventListener('click', function(){
    if (setAvaiable == true) { // Wenn ein Set schon generiert worden ist / verfügbar ist
        addToSetfunction()
    } else {
        setAvaiable = true;
        addToSet.innerHTML = "Add to set"; // Ändert innerHTML für user expirience
        addANewLi(); // Führt funtion addANewLi aus
    }
});

// Click event für die Funktion closeAddToSet hinzufügen
addToSetContainer.addEventListener('click', closeAddToSet);

function addANewLi(){ // Fügt eine neue LI für das einfügen der Sets hinzu
    // Selector variabeln vorbereiten
    const numberOfAllLi = document.querySelectorAll('.addToSetBG ul li');
    const numberOfAllLis = numberOfAllLi.length;

    numberOfAllLi.forEach(li => { // löscht alle LIs und fügt diese neu hinzu um doppelte klick events zu vermeiden
        li.remove();
    });

    for (let i = 0; i < numberOfAllLis; i++) {
        const createLi = document.createElement("li")
        const inhalt = `Set ${i + 1}`;
        createLi.classList.add(`liSet${i + 1}`)
        createLi.innerHTML = inhalt;
        addToSetUl.appendChild(createLi);
    }

    const numberOfLi = numberOfAllLi.length + 1;
    const createLi = document.createElement("li")
    const inhalt = `Set ${numberOfLi}`;
    createLi.classList.add(`liSet${numberOfLi}`)
    createLi.innerHTML = inhalt;
    addToSetUl.appendChild(createLi);

    refreshClickEventsLis(); // Führt die funktion refreshClickEventsLis aus um die klick events neu zu generieren
}

function refreshClickEventsLis() { // Generiert die klick Events aller LIs
    // Selector variabeln vorbereiten
    const allAddToSetLis = document.querySelectorAll('.addToSetBG ul li');

    // Click events für alle LI's im AddToSet hinzufügen
    allAddToSetLis.forEach(li => {
        li.addEventListener('click', function(){
            // console.log(li.innerHTML.slice(4,5));
            addItemtoSet(li.innerHTML.slice(4,5));
        })
    });

    addNewSet(); // Führt die funktion addNewSet aus um einen neuen Set Container zu generieren
}

function onlyRefreshClickEventsLis() { // Generiert die klick Events aller LIs ohne einen neuen Set hinzuzufügen
    const allAddToSetLis = document.querySelectorAll('.addToSetBG ul li');

    // debugger;

    // Click events für alle LI's im AddToSet hinzufügen
    allAddToSetLis.forEach(li => {
        li.addEventListener('click', function(){
            // console.log(li.innerHTML.slice(4,5));
            addItemtoSet(li.innerHTML.slice(4,5)); // führt die funktion addItemtoSet mit der Zahl des ausgewählten Sets
        })
    });
}

function addNewSet() {// Generiert einen neuen Set Container

    // Selector Variabeln vorbereiten
    const allSets = document.querySelectorAll('.sets');

    // Prüfen, ob schon sets vorhanden sind
    if (allSets.length == 0) {

        // erstelle neuen set
        const newdiv = document.createElement('div');
        newdiv.classList.add("sets");
        newdiv.classList.add("setContainer1");
        const divInhalt = `<p class="setNumber">Set 1</p>
        <hr>
        <label for="set1"> Set Title
            <input type="text" name="set1" id="set1" value="">
        </label>
        <div class="setContainer">
        </div>
        <i class='far fa-trash-alt trash1'></i>`;

        newdiv.innerHTML = divInhalt;

        itemSetContainer.appendChild(newdiv);

        setAvaiable = true; // setzt die Variabel setAvaiable auf true. Jetzt ist ein Set vorhanden!
        
        // Führt addDeletefunktion funktion aus
        addDeletefunktion();

    } else {

        // Selector Variabeln vorbereiten
        const newSetNumber = allSets.length + 1;

        // Prüft, ob es schon 9 Sets hat, wenn ja, dann soll ein error ausgeführt werden
        if (newSetNumber >= 10) {
            // console.log("you can't have more than 9 Sets");
        } else {
            // erstelle neuen set
            const newdiv = document.createElement('div');
            newdiv.classList.add(`sets`);
            newdiv.classList.add(`setContainer${newSetNumber}`);
            const divInhalt = `<p class="setNumber">Set ${newSetNumber}</p>
            <hr>
            <label for="set${newSetNumber}"> Set Title
                <input type="text" name="set${newSetNumber}" id="set${newSetNumber}" value="">
            </label>
            <div class="setContainer">
                
            </div>
            <i class='far fa-trash-alt trash${newSetNumber}'></i>`;

            newdiv.innerHTML = divInhalt;

            itemSetContainer.appendChild(newdiv);

            // Führt addDeletefunktion funktion aus
            addDeletefunktion();
        }
    }
    
}

function addDeletefunktion() { // Füge Klick event für die Delete Buttons der Sets hinzu
    // Selector Variabeln vorbereiten
    const allDeleteButtons = document.querySelectorAll('.sets i');
    allDeleteButtons.forEach(deleteButton => {
        deleteButton.addEventListener('click', deleteSet);
    });
}

function deleteSet() { // Lösche ein Set
    // Variabeln vorbereiten
    const setNumber = this.className.slice(22, 23); // Nummer des zu löschenden Sets
    // Wählt den zu löschenden sets div und Li aus
    const deleteSet = document.querySelector(`.setContainer${setNumber}`);
    const deleteLi = document.querySelector('.addToSetBG ul .liSet' + setNumber);

    // console.log(deleteSet);
    // Löscht SET und LI
    deleteSet.remove();
    deleteLi.remove();

    renameTheSetsAndLis(setNumber); // Führt RenameTheSets funktion aus
}

function renameTheSetsAndLis(deleteSetNumber){ // Sets und LIS richtig nummerieren, deleteSetNumber ist die Zahl des Gelöschten Sets
    // Selector Variabeln vorbereiten
    const allSets = document.querySelectorAll('.sets');
    const allAddToSetLis = document.querySelectorAll('.addToSetBG ul li'); 
    // Variabeln vorbereiten
    i = 1;
    x = 1;

    allSets.forEach(set => { // Iteriert durch alle Sets durch
        // console.log(set);
        // Variabeln vorbereiten
        setItems = [];
        const setClassName = set.className.slice(5, 18); // Beispiel: "setContainer2"
        const setNumber = set.className.slice(17, 18); // Beispiel: "2"

        const allItems = document.querySelectorAll('.' + setClassName + ' .setContainer .itemContainer'); // Selector für alle Items
        const getTitle = document.querySelector('.' + setClassName + ' #set' + setNumber); // Selector für den Set Titel
        const titleName = getTitle.value; // Value des Titel Inputs

        let newSetNumber = setNumber - 1;
        let currentItemNumber = 1;

        // holt sich alle Items aus dem Sets, welche nicht gelöscht werden
        allItems.forEach(item => {

            let inputOfItem = item.querySelector("input"); // Holt sich die daten des Hidden Inputs, Beispiel: <input type="hidden" name="Set1item1" value="Set1item2003">

            // Prüft ob sich Items im container befinden
            if (inputOfItem) {
                // console.log("there is an item");
                // Speichert die Daten des einzelnen Items in Variabeln
                const itemsrc = item.querySelector("img").src;
                const itemalt = item.querySelector("img").alt;
                const itemdataname = item.querySelector("img").dataset.name;
                const itemdatacost = item.querySelector("img").dataset.cost;
                let itemInput = "";

                if (setNumber < deleteSetNumber) { // Wenn setNumber kleiner ist als die vorher gelöschte Set Number
                    newSetNumber = setNumber;
                } else {
                    // newSetNumber = setNumber - 1;
                }                
                // Erstellt den Ihnalt des Items
                itemInput = `<div class="itemContainer">
                <img src="${itemsrc}" alt="${itemalt}" data-cost="${itemdatacost}" data-name="${itemdataname}">
                <input type="hidden" name="Set${newSetNumber}item${currentItemNumber}" value="Set${newSetNumber}item${itemdataname}">
                </div>`; 

                currentItemNumber++;
    
                setItems.push(itemInput); // Pusht das Erstellte Item in das Array

            } else {
                // console.log("there is no item");
            }
        });        
        // Sets umschreiben
        set.classList.replace(setClassName, `setContainer${i}`); // ersetzt Klassen Name
        // Schreibt Inhalt für den Set
        let setInhalt = `<p class="setNumber">Set ${i}</p>
        <hr>
        <label for="set${i}"> Set Title
            <input type="text" name="set${i}" id="set${i}" value="${titleName}">
        </label>
        <div class="setContainer">`;
        setItems.forEach(item => { // Fügt die gespeicherten Items in das Set hinzu
            setInhalt += item;
        });
        setInhalt += `</div> 
        <i class='far fa-trash-alt trash${i}'></i>`;
        
        set.innerHTML = setInhalt;
        i++;
    });

    allAddToSetLis.forEach(li => { // Fügt Inhalt in die LIs hinzu
        li.outerHTML = `<li class="liSet${x}" style="opacity: 0; visibility: hidden;">Set ${x}</li>`
        x++;
    });

    // Prüfen, ob schon sets vorhanden sind
    if (allSets.length == 0) {
        setAvaiable = false;
        addToSet.innerHTML = "Create a set first";
    } else {
        setAvaiable = true;
    }
    // Führt triggerSortierung funktion aus
    triggerSortierung();
    // Führt onlyRefreshClickEventsLis funktion aus
    onlyRefreshClickEventsLis();
    // Führt addDeletefunktion funktion aus
    addDeletefunktion();
}

function addToSetfunction() { // Öffnet das AddToSet Container mit greensock animation
    // Selector Variabeln vorbereiten
    const addToSetBG = document.querySelector('.addToSetBG');
    const numberOfAllLi = document.querySelectorAll('.addToSetBG ul li');

    // Greensock vorbereiten
    const openingtimeline = gsap.timeline();

    openingtimeline.to(addToSetBG,{
        duration: 0.05,
        autoAlpha: 1
    })
    .to(numberOfAllLi,{
        duration: 0.07,
        autoAlpha: 1,
        opacity: 1,
        onComplete:function(){
            loadLIMenu = true; // Nur relevant für das abwarten der Animation
        },
        stagger: {
            each: 0.03
        }
    });
}

function closeAddToSet(){ // Schliesst das AddToSet Container

    // Selector Variabeln vorbereiten
    const addToSetBG = document.querySelector('.addToSetBG');
    const numberOfAllLi = document.querySelectorAll('.addToSetBG ul li');

    // Greensock vorbereiten
    const closingtimeline = gsap.timeline();

    // Prüfen ob die LI's noch laden
    if(loadLIMenu == true){
        closingtimeline.to(numberOfAllLi,{
            duration: 0.01,
            autoAlpha: 0
        })
        .to(addToSetBG,{
            duration: 0.01,
            autoAlpha: 0
        });
        loadLIMenu = false;
    } else {
        // console.log("wait")
    }
}

function addItemtoSet(setNumber){ // Item wird im Set hinzugefügt. Beispiel: setNumber = 3 

    if (setAvaiable == true) {
        // Selector Variabeln vorbereiten
        const choosenSet = `.itemSetsWrapper .setContainer${setNumber}`;
        const checkIfItem = document.querySelector(".itemInfosHeader .itemName");

        if( checkIfItem.innerHTML == "" ){
            // console.log("no Item selected");
            feedback(0, "Kein Item ausgewählt!"); // Error Feedback für user Expirience ausgeben

        } else {
            // console.log("Item selected");
            const choosenSetselContainer = `${choosenSet} .setContainer`;
            const ItemContainerdocument = document.querySelector(choosenSetselContainer);
            // console.log(ItemContainerdocument);
            const choosenSetselContainerWItems = `${choosenSet} .setContainer .itemContainer`;

            let allItems = [];
            const allItemsContainer = document.querySelectorAll(choosenSetselContainerWItems);
            const numberOfItems = allItemsContainer.length;
            if (numberOfItems == 10) { // Error, too many Items
                feedback(0, "Maximal 10 Items pro Set möglich!"); // feedback für User Expirience ausgeben
            } else {
                allItemsContainer.forEach(item => {
                    // console.log(item);
                    allItems.push(item.outerHTML);
                });
    
                const headerInfoimg = document.querySelector('.itemInfosHeader img');
    
                const createDiv = document.createElement("div");
                createDiv.classList.add("itemContainer");
    
                const createImage = document.createElement("img");
                createImage.src = headerInfoimg.src;
                createImage.alt = headerInfoimg.alt;
                createImage.setAttribute("data-cost", headerInfoimg.dataset.cost);
                createImage.setAttribute("data-name", headerInfoimg.dataset.name);
    
                createDiv.appendChild(createImage);
                
                const createInput = document.createElement("input");
                createInput.setAttribute("type", "hidden");
                createInput.setAttribute("name", `Set${setNumber}item${numberOfItems + 1}`);
                createInput.setAttribute("value", `Set${setNumber}item${headerInfoimg.dataset.name}`)
                
                createDiv.appendChild(createInput);
    
                // const testestest = document.querySelector('.setContainer1 .setContainer')
                // console.log(ItemContainerdocument);
    
                ItemContainerdocument.appendChild(createDiv);
    
                triggerSortierung();
    
                updateItemsInContainer(setNumber);    
            }
        }
    } else {
        addNewSet();
        setAvaiable = true;
    }
}

function triggerSortierung() { // Macht alle Items in den Sets Sortierbar
    $( function (){
        $(".setContainer").sortable({
            update: function( event, ui ) {
                const setNumber = this.querySelector('input').getAttribute("name").slice(3,4);
                updateItemsInContainer(setNumber);
            }
        });
    });
}

function updateItemsInContainer(setNumber) {
    setItems = [];
    // console.log(setNumber)
    const setClassName = `.setContainer${setNumber}`;
    const allItems = document.querySelectorAll(setClassName + ' .setContainer .itemContainer');
    let currentItemNumber = 1;
    let currentSetNumber = setNumber;

    if(allItems.length >= 1){

        allItems.forEach(item => {
        
            const itemsrc = item.querySelector("img").src;
            const itemalt = item.querySelector("img").alt;
            const itemdataname = item.querySelector("img").dataset.name;
            const itemdatacost = item.querySelector("img").dataset.cost;
            let itemInput = "";              
    
            itemInput = `<div class="itemContainer">
            <img src="${itemsrc}" alt="${itemalt}" data-cost="${itemdatacost}" data-name="${itemdataname}">
            <input type="hidden" name="Set${currentSetNumber}item${currentItemNumber}" value="Set${currentSetNumber}item${itemdataname}">
            </div>`; 
    
            currentItemNumber++;
            setItems.push(itemInput);
        })
    
        const theSetContainer = document.querySelector(setClassName + ' .setContainer');
        let allItemsInContainer = document.querySelectorAll(setClassName + ' .setContainer .itemContainer');
        const test = document.querySelector(setClassName + ' .setContainer .itemContainer img');
        
        allItemsInContainer.forEach(item => {
            item.remove();
        });
    
        let setInhalt = "";
        setItems.forEach(item => {
            setInhalt += item;
        });
    
        theSetContainer.innerHTML = `${setInhalt}`;
    
        let allItemsInContainer2 = document.querySelectorAll(setClassName + ' .setContainer .itemContainer');
    
        allItemsInContainer2.forEach(item => {
            item.addEventListener("contextmenu", (e)=>{
                e.preventDefault();
                
                item.remove();
                updateItemsInContainer(setNumber);
                return false;
    
            }, false);

            item.addEventListener("click", (e)=>{
                e.preventDefault();
                
                item.remove();
                updateItemsInContainer(setNumber);
                return false;
    
            }, false);
        });
    }
}

function changeItemFilter(){ // Ändert die Filter 
    // console.log(this.id);
    const idOfFilter = this.id;
    const allFilter = document.getElementById("All"); // Nicht verwechseln mit Alle Filter, hier wird der Filter "All" angesprochen
    if (this.className == "active") { // Wenn der Filter schon aktiv ist, soll dieser entfernt werden
        // const lengthOfId = this.id.length;
        const startOfElement = selectedFilters.indexOf(this.id) // IndexOf des Arrays der ausgewählten Filter

        this.classList.remove("active")
        selectedFilters.splice(startOfElement, startOfElement + 1);
        // console.log(selectedFilters);
        listItemsInShop();
        
        if (selectedFilters.length == 0 || idOfFilter == "All") { // wenn keine Filter aktiv sind oder "All" geklickt worden ist
            allFilter.classList.add("active");
            selectedFilters = ["All"];
            listItemsInShop();
            // console.log(selectedFilters);
        }
    } else {
        if (idOfFilter != "All") { // Wenn ein Filter geklickt worden ist was nicht "All" ist.
            this.classList.add("active")
            selectedFilters.push(idOfFilter);
            // console.log(selectedFilters);

            const startOfAll = selectedFilters.indexOf("All");
            selectedFilters.splice(startOfAll, startOfAll + 1);
            allFilter.classList.remove("active");
            // console.log(selectedFilters.indexOf("All"));
            listItemsInShop();
        } else {
            const allFilters = document.querySelectorAll(".itemsFilter ul li");
            allFilters.forEach(filter => {
                filter.classList.remove("active");
                selectedFilters = ["All"]
            });
            allFilter.classList.add("active");
            // console.log(selectedFilters);
            listItemsInShop();
        }         
    }
}

// Alle Items auflisten
function listItemsInShop(){
    fetch(`https://ddragon.leagueoflegends.com/api/versions.json`)
    .then(response => response.json())
    .then(data => {
        fetch(`https://ddragon.leagueoflegends.com/cdn/${data[0]}/data/en_US/item.json`)
        .then(response => response.json())
        .then(item => {
    
        const allItemsContainer = document.querySelector('.allItems');
        const allItemDivs = document.querySelectorAll('.allItems div');
        let numberOfFilters = selectedFilters.length;
        const numberOfAllFilters = document.querySelectorAll('.itemsFilter ul li').length;
        // console.log(numberOfFilters)

        allItemDivs.forEach(div => {
            div.remove();
        });
    
        const orderedNumbers = []
        for(x in item.data){
          orderedNumbers.push(x)
        }
    
        //Save as array : 
    
        const newDataArray = []
        orderedNumbers.forEach(entry => {
          newDataArray.push(item.data[entry])
        })
    
        // sort by gold value
        newDataArray.sort(function (a, b) {
          return a.gold.total - b.gold.total;
        });

        // for (let i = 0; i < numberOfFilters; i++) {
        //     console.log(selectedFilters[i]);
        // }

        // Items nach filter anzeigen lassen
        newDataArray.forEach(sortedItem => {

            if(selectedFilters[0] == "All") {

                if(sortedItem.inStore == false) {
                
                } else {

                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }
            } else if (numberOfFilters == 1) {

                if(sortedItem.inStore == false) {
                
                } else if (sortedItem.tags.includes(`${selectedFilters[0]}`)){
                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }
            } else if (numberOfFilters == 2) {

                if(sortedItem.inStore == false) {
                
                } else if (sortedItem.tags.includes(`${selectedFilters[0]}`) && sortedItem.tags.includes(`${selectedFilters[1]}`)){
                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }
            } else if (numberOfFilters == 3) {

                if(sortedItem.inStore == false) {
                
                } else if (sortedItem.tags.includes(`${selectedFilters[0]}`) && sortedItem.tags.includes(`${selectedFilters[1]}`) && sortedItem.tags.includes(`${selectedFilters[2]}`)){
                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }

            } else if (numberOfFilters == 4) {

                if(sortedItem.inStore == false) {
                
                } else if (sortedItem.tags.includes(`${selectedFilters[0]}`) && sortedItem.tags.includes(`${selectedFilters[1]}`) 
                && sortedItem.tags.includes(`${selectedFilters[2]}`) && sortedItem.tags.includes(`${selectedFilters[3]}`)){
                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }

            } else if (numberOfFilters == 5) {

                if(sortedItem.inStore == false) {
                
                } else if (sortedItem.tags.includes(`${selectedFilters[0]}`) && sortedItem.tags.includes(`${selectedFilters[1]}`) 
                && sortedItem.tags.includes(`${selectedFilters[2]}`) && sortedItem.tags.includes(`${selectedFilters[3]}`) && sortedItem.tags.includes(`${selectedFilters[4]}`)){
                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }

            } else if (numberOfFilters == 6) {

                if(sortedItem.inStore == false) {
                
                } else if (sortedItem.tags.includes(`${selectedFilters[0]}`) && sortedItem.tags.includes(`${selectedFilters[1]}`) 
                && sortedItem.tags.includes(`${selectedFilters[2]}`) && sortedItem.tags.includes(`${selectedFilters[3]}`) 
                && sortedItem.tags.includes(`${selectedFilters[4]}`) && sortedItem.tags.includes(`${selectedFilters[5]}`)){
                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }

            } else if (numberOfFilters == 7) {

                if(sortedItem.inStore == false) {
                
                } else if (sortedItem.tags.includes(`${selectedFilters[0]}`) && sortedItem.tags.includes(`${selectedFilters[1]}`) 
                && sortedItem.tags.includes(`${selectedFilters[2]}`) && sortedItem.tags.includes(`${selectedFilters[3]}`) 
                && sortedItem.tags.includes(`${selectedFilters[4]}`) && sortedItem.tags.includes(`${selectedFilters[5]}`)
                && sortedItem.tags.includes(`${selectedFilters[6]}`)){
                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }

            } else if (numberOfFilters == 8) {

                if(sortedItem.inStore == false) {
                
                } else if (sortedItem.tags.includes(`${selectedFilters[0]}`) && sortedItem.tags.includes(`${selectedFilters[1]}`) 
                && sortedItem.tags.includes(`${selectedFilters[2]}`) && sortedItem.tags.includes(`${selectedFilters[3]}`) 
                && sortedItem.tags.includes(`${selectedFilters[4]}`) && sortedItem.tags.includes(`${selectedFilters[5]}`)
                && sortedItem.tags.includes(`${selectedFilters[6]}`) && sortedItem.tags.includes(`${selectedFilters[7]}`)){
                    const nameOfItemFull = sortedItem.image.full.split(".");
                    const nameOfItem = nameOfItemFull[0];
            
                    const createDiv = document.createElement("div");
                    createDiv.classList.add("itemImgContainer");
                    const createImage = document.createElement("img");
                    createImage.src = `../img/symbols/items/${sortedItem.image.full}`;
                    createImage.alt = `${sortedItem.image.full} / Image of ${sortedItem.name}`;
                    createImage.setAttribute("data-cost", `${sortedItem.gold.total}`)
                    createImage.setAttribute("data-name", nameOfItem)
                    // console.log(createImage);
            
                    createDiv.appendChild(createImage);
            
                    allItemsContainer.appendChild(createDiv);

                }

            } 
            
        })
    
        const allImages = document.querySelectorAll(".allItems .itemImgContainer img");
        // console.log(allImages);
    
        allImages.forEach(image => {
            image.addEventListener('click', showImageInfos);
        });
    
      })
    })
};


function showImageInfos(){
    let Imagedatas = this.alt.split('.');
    const theImage = Imagedatas[0];
    const ImagedatasFull = theImage + ".png";

    fetch(`https://ddragon.leagueoflegends.com/api/versions.json`)
        .then(response => response.json())
        .then(data => {
            // Imagedata = this.alt.split('.');
            fetch(`https://ddragon.leagueoflegends.com/cdn/${data[0]}/data/en_US/item.json`)
            .then(response => response.json())
            .then(data => {
                for(x in data.data){
                    if(data.data[x].image.full == ImagedatasFull){
                        // console.log(data.data[x].name);
                        // const headerInfo = document.querySelector('.itemInfosHeader');
                        const nameOfItemFull = data.data[x].image.full.split(".");
                        const nameOfItem = nameOfItemFull[0];

                        const headerInfoimg = document.querySelector('.itemInfosHeader img');
                        const headerInfoitemname = document.querySelector('.itemInfosHeader .itemName');
                        const headerInfoitemcost = document.querySelector('.itemInfosHeader .itemCost');
                        const headerInfoitemsell = document.querySelector('.itemInfosHeader .itemSell');
                        const bottomiteminfos = document.querySelector('.itemInfosBottom');

                        headerInfoimg.src = `../img/symbols/items/${data.data[x].image.full}`;
                        headerInfoimg.alt = `Image of ${data.data[x].name}`;
                        headerInfoimg.setAttribute("data-cost", `${data.data[x].gold.total}`)
                        headerInfoimg.setAttribute("data-name", nameOfItem)


                        headerInfoitemname.innerHTML = data.data[x].name;
                        headerInfoitemcost.innerHTML = "Cost: <span>" + data.data[x].gold.total + "g";
                        headerInfoitemsell.innerHTML = "Sell: <span>" + data.data[x].gold.sell + "g";
                        bottomiteminfos.innerHTML = data.data[x].description;
                        
                    }
                }
            })
        })
};




