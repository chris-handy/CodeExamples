// JavaScript.js
var responseData;

var start = -1;
window.onload = function(){
    //this will run as soon as the page finishes loading
	
    request.open('POST', 'http://mmweb1/staff/steveg/mtm4022/sampleQuotesJSON.php', true);
    //request.open('POST', 'sampleQuotesJSON.php', true);

    request.onreadystatechange = function(){
        //the readyState property goes through the stages 0,1,2,3,4
        //4 being all loaded
        if(request.readyState ==4 ){
            //A file has loaded
            switch( request.status){
                case 200:
                //OK
                responseData = eval( '(' +  request.responseText + ')' );
                next_quote(1);
                break;
                case 404:
                //file not found
                alert('Sorry, my dog ate the file');
                break;
                case 403:
                //permission denied
                alert("Sorry, my mom won't let me give you the file");
                break;
                case 500:
                //serverside error
                alert('PHP FELL ASLEEP WHILE BUILDING IT. SORRY');
                break;
                default:
                alert('Status: ' +request.status);
            }
        }
    }

    request.send(null);
}
function next_quote(x) {
    start+=x;
    if(start >= responseData.items.length) {
        start = 0;
    }
    if(start <= -1) {
        start = responseData.items.length-1;
    }
    while (document.getElementById('quote').firstChild) {
        document.getElementById('quote').removeChild(document.getElementById('quote').firstChild);
    }
	var h1 = document.createElement('h1');
	var p = document.createElement('p')
	var s = document.createElement('span')
	
	var title = document.createTextNode(responseData.heading);
    var quote = document.createTextNode(responseData.items[start].text);
    var author = document.createTextNode(' - ' + responseData.items[start].person);
		
	h1.appendChild(title);
	p.appendChild(quote);
	s.appendChild(author);
	
	document.getElementById("quote").appendChild(h1);
    document.getElementById("quote").appendChild(p);
	document.getElementById("quote").appendChild(s);
}