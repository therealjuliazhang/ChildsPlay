/*
=======================================
Title:Upload Image; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789); 
=======================================
*/
document.addEventListener('DOMContentLoaded', function() {
	var elems = document.querySelectorAll('select');
	var instances = M.FormSelect.init(elems);
});

document.addEventListener('DOMContentLoaded', function() {
	var elem = document.querySelectorAll('.tooltipped');
	var instance = M.Tooltip.init(elem);
});	

$(document).ready(function() {
	var selected = $("#activityStyle option:selected").val();
	selectActivityStyle();
	//loadContent();
	$(document).on('change', '#file', function(){
		var path = $("#imageAddress").val();
		var length = document.getElementById("file").files.length;
		var form = new FormData();	
		var check = document.getElementById("file").getAttribute("name");
				
		if(check == "files[]"){
			for(var i = 0; i < length; i++){
				var property = document.getElementById("file").files[i];
				form.append("files[]", property)
			}
		}
		else if(check == "file"){
			var property = document.getElementById("file").files[0];
			form.append("file", property);
		}
		$.ajax({
			url: "uploadImage.php",
			method: "POST",
			data: form,
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function(){
				$('#imageUpload').html('<label>Loading...</label>');
			},
			success: function(data){
				$('#imageUpload').html(data);
				$('#results').html("");
			}
		})
	})
});

function loadContent(){
	//selectActivityStyle();
	var selected = $("#activityStyle option:selected").val();
	switch(selected){
		case "Likert Scale":
				$("#instruction").val("Do you like this monster? Touch the smiley face if you like it and touch the sad face if you don't like it.");
			break;
		case "Character Ranking":
				$("#instruction").val("Press your favourite character and then your next favourite until they are all pressed.");
			break;
		case "Identify Body Parts":
				$("#instruction").val("Can you see the monster's [enter body part]? Touch the monster's [enter body part].");
			break;
		case "Preferred Mechanics":
				$("#instruction").val("How would you [action made on monster] if the paper was a touch screen?");
			break;
	}
	selectActivityStyle();
}

function selectActivityStyle(){
	var selected = $("#activityStyle option:selected").val();
	$.post("selectOption.php", {option_value: selected},
		function(data){
			var input = document.getElementById("file");
			var upload = document.getElementById("upload");
			var noti = document.createElement("label");
			if(data == "Character Ranking"){
				input.setAttribute("name", "files[]");
				input.setAttribute("multiple", "multiple");
				//create the points input when user selects Character Ranking activity style
				var header = document.createElement("h5");
				header.setAttribute("class", "blue-text darken-2 header");
				header.innerHTML = "Points interval";
				var div = document.createElement("div");
				div.setAttribute("class", "input-field col s7");
				var pointInput = document.createElement("input");
				pointInput.setAttribute("id", "points");
				pointInput.setAttribute("name", "points");
				pointInput.setAttribute("type", "number");
				pointInput.setAttribute("min", 1);
				pointInput.setAttribute("pattern", "\d*");
				div.appendChild(pointInput);
				var wrapper = document.getElementById("pointRow");
				wrapper.appendChild(header);
				wrapper.appendChild(div);
				
				//delete the previous label
				upload.removeChild(upload.lastChild);
				//add the label telling user that they can upload multiple images for Character Ranking task
				noti.innerHTML = "You can upload multiple images for Character Ranking activity style";
				upload.appendChild(noti);
			}
			else{
				input.setAttribute("name", "file");
				input.removeAttribute("multiple");
				//delete the previous label
				upload.removeChild(upload.lastChild);
				//add the label telling user that they can only upload one image for other tasks
				noti.innerHTML = "Please select one image to upload";
				upload.appendChild(noti);
				//delete the point input for other tasks
				var contents = document.getElementById("pointRow");
				while (contents.hasChildNodes()) {
					contents.removeChild(contents.lastChild);
				}
			}
		}
	);
}