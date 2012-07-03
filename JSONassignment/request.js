// JavaScript Document

var request;

try{
	request = new XMLHttpRequest();
}catch(e){
	try{
		request = new ActiveXObject("MSXml.XMLHTTP");
	}catch(e1){
		try{
			request = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(e2){
			request = null;
		}
	}
}