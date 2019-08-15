//creates a row for inputing for preschool data
function addRow(preschooler=0){
    var newRow = document.createElement("div");
    newRow.className = ("row");
    addInput("name", newRow, preschooler);
    addInput("age", newRow, preschooler);
    addRadio("male", newRow, preschooler);
    addRadio("female", newRow, preschooler);
    var iconDiv = document.createElement("div");
    //implements remove row
    iconDiv.addEventListener("click", function() {
        rowsDiv.removeChild(newRow);
    }, false);
    iconDiv.classList.add("col", "s1", "changeCursor");
    var removeIcon = document.createElement("i");
    removeIcon.classList.add("material-icons", "medium", "icon-red", "tooltipped"); 
    removeIcon.innerHTML = "remove";
    removeIcon.setAttribute("data-position", "right");
    removeIcon.setAttribute("data-tooltip", "Remove row");
    iconDiv.appendChild(removeIcon);
    newRow.appendChild(iconDiv);
    rowsDiv.appendChild(newRow);
    num++;
}
//creates text field input
function addInput(type, row, preschooler=0){
    var newDiv = document.createElement("div");
    var newInput = document.createElement("input");
    var newLabel = document.createElement("label");
    newInput.className = "validate";
    newInput.setAttribute('required', "");
    newInput.setAttribute('aria-disabled', true);
    if (type == "name"){
        newDiv.classList.add("input-field", "col", "s5");
        newInput.id = "name" + num;
        newInput.name = "name" + num;
        if(preschooler!=0)
            newInput.value = preschooler['name'];
        newInput.type = "text";
        newLabel.innerHTML = "Name";
    }
    else if(type == "age"){
        newDiv.classList.add("input-field", "col", "s2");
        newInput.id = "age" + num;
        newInput.name = "age" + num;
        if(preschooler!=0)
            newInput.value = preschooler['age'];
        newInput.type = "number";
        newLabel.innerHTML = "Age";
    }
    newLabel.htmlFor = newInput.id;
    newDiv.appendChild(newInput);
    newDiv.appendChild(newLabel);
    row.appendChild(newDiv);
}
// //creates radio button
function addRadio(gender, row, preschooler=0){
    var newDiv = document.createElement("div");
    var newP = document.createElement("p");
    var newInput = document.createElement("input");
    var newLabel = document.createElement("label");
    newDiv.classList.add("col", "s2");
    newInput.type = 'radio';
    newInput.required = true;
    if (gender == "male"){
        newInput.id = "genderM" + num;
        newInput.name = "gender" + num;
        newInput.value = "Male";
        if(preschooler!=0)
            if(preschooler['gender']=="Male")
                newInput.checked = true;
        newLabel.innerHTML = "Male";
    }
    else if(gender == "female"){
        newInput.id = "genderF" + num;
        newInput.name = "gender" + num;
        newInput.value = "Female";
        if(preschooler!=0)
            if(preschooler['gender']=="Female")
                newInput.checked = true;
        newLabel.innerHTML = "Female";
    }
    newLabel.htmlFor = newInput.id;
    newP.appendChild(newInput);
    newP.appendChild(newLabel);
    newDiv.appendChild(newP);
    row.appendChild(newDiv);
}