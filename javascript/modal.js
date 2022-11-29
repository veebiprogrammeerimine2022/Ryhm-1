let photoDir = "photo_upload_normal/";
let photoId;

window.onload = function(){
	//kõik pisipildid paneme dialoogiakent avama
	let allThumbs = document.querySelector(".gallery").querySelectorAll(".thumbs");
	for(let i = 0; i < allThumbs.length; i ++){
		allThumbs[i].addEventListener("click", openModal);
	}
	document.querySelector("#modalclose").addEventListener("click", closeModal);
	document.querySelector("#modalimage").addEventListener("click", closeModal);
}

function openModal(e){
	photoId = e.target.dataset.id;
	for(let i = 1; i < 6; i ++){
		document.querySelector("#rate" + i).checked = false;
	}
	document.querySelector("#modalimage").src = photoDir + e.target.dataset.filename;
	document.querySelector("#modalcaption").innerHTML = e.target.alt;
	document.querySelector("#storeRating").addEventListener("click", storeRating);
	document.querySelector("#modal").showModal();
}

function closeModal(){
	document.querySelector("#modal").close();
}

function storeRating(){
	//console.log("Hindame");
	let rating = 0;
	for(let i = 1; i < 6; i ++){
		if(document.querySelector("#rate" + i).checked){
			rating = i;
		}
		//console.log(rating);
	}
	if(rating > 0){
		//salvestame
		//saadame info serverisse PHP skriptile, mis salvestab ja tagastab kliendile värskendatud keskmise hinde
		//AJAX
		//Asynchroneus Javascript And XML
		let webRequest = new XMLHttpRequest();
		//oleme valmis eduks ja kui asjad toimivad, siis jälgime, kas õnnestus
		webRequest.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				//kõik, mida teha, kui tuli vastus
				document.querySelector("#avgrating").innerHTML = this.responseText;
				document.querySelector("#storeRating").removeEventListener("click", storeRating);
			}
		};
		//paneme tööle
		//    store_photorating.php?photo=33&rating=4
		webRequest.open("GET", "store_photorating.php?photo=" + photoId + "&rating=" + rating, true);
		webRequest.send();
		
	}//if rating > 0 lõppeb
}