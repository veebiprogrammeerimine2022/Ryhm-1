//console.log("Töötab!");

let fileSizeLimit = 1.5 * 1024 * 1024;

window.onload = function(){
	document.querySelector("#photo_submit").disabled = true;
	document.querySelector("#photo_input").addEventListener("change", checkSize);
}

function checkSize(){
	//console.log(document.querySelector("#photo_input").files[0]);
	if(document.querySelector("#photo_input").files[0].size <= fileSizeLimit){
		document.querySelector("#photo_submit").disabled = false;
		document.querySelector("#infoPlace").innerHTML = "";
	} else {
		document.querySelector("#photo_submit").disabled = true;
		document.querySelector("#infoPlace").innerHTML = "Valitud fail on <strong>liiga</strong> suur!";
	}
}