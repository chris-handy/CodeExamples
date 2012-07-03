window.onload=function(){
	var tr=document.getElementsByTagName("tr")
	for(var i=0;i<tr.length;i++){
		tr[i].onmouseover = function(){
			over(this);
		}
		tr[i].onmouseout = function(){
			out(this);
		}
	}
}

//mousovers/ouuts
var changeColor;

function over (aColor) {
	changeColor = aColor.className;
	aColor.className = 'over';
	
	}
function out(aColor){
	aColor.className = changeColor;
	}
	
	

//changerowcolours	
function alternate(){
	var tr=document.getElementsByTagName("tr")
	for(var i=1;i<tr.length;i++){
		if(i%2==0){
			tr[i].className="alternateColor"
		}else{
		tr[i].className="whiteColor"	
		}
	}
}



//takecoloursoff
function remove(){
	var tr=document.getElementsByTagName("tr")
	for(var i=1;i<tr.length;i++){
		if(i%2==0){
			tr[i].className="whiteColor"
		}else{
		tr[i].className="whiteColor"	
		}
	}
}

	
