document.addEventListener('DOMContentLoaded', function() {
	var elems = document.querySelectorAll('select');
	var instances = M.FormSelect.init(elems);
});

document.addEventListener('DOMContentLoaded', function() {
	var elem = document.querySelectorAll('.tooltipped');
	var instance = M.Tooltip.init(elem);
});	

$(document).ready(function() {
	loadContent();
	
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
	var selected = $("#activityStyle option:selected").val();
	switch(selected){
		case "Likert Scale":
			$("#instruction").val("Press the happy face if you like it, press the sad face if you don't like it.");
			break;
		case "Character Ranking":
			$("#instruction").val("Press your favourite character and then your next favourite until they are all pressed.");
			break;
		case "Identify Body Part":
			$("#instruction").val("Press the monster's [enter body part]");
			break;
		case "Preferred Mechanics":
			$("#instruction").val("");
			break;
	}
	$.post("selectOption.php", {option_value: selected},
		function(data){
			var input = document.getElementById("file");
			if(data == "Character Ranking"){
				input.setAttribute("name", "files[]");
				input.setAttribute("multiple", "multiple");
			}
			else{
				input.setAttribute("name", "file");
				input.removeAttribute("multiple");
			}
		}
	);
}