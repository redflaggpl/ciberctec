function nuevoAjax(){
	var xmlhttp=false;
 	try {
 		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 	} catch (e) {
 		try {
 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 		} catch (E) {
 			xmlhttp = false;
 		}
  	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}


 function confirmar ( mensaje ) {
	 return confirm( mensaje );
 }
 
 function cerrar(capa) {
	 div = document.getElementById(capa);
	 div.style.display='none';
	 
}
 

function cambiar(nomimg)
{
	document.forms.adminForm.urlfoto.value=nomimg;
}

/**
 * Crea div con evento seleccionado en componente agenda
 * @param int eid id del evento
 */
function getEvent(eid)
{
	var eid;
	
	eventdisplay = document.getElementById('eventdisplay');
	ajax=nuevoAjax();
	ajax.open("GET", "consultas.ajax.php?act=getEvent&eid="+eid,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			eventdisplay.innerHTML = ajax.responseText
		 }
	}
	ajax.send(null);
}

/**
 * @desc registra usuario en gripo
 * @param int usuario_id
 * @param int group_id
 * @return
 */
function setGroup(usuario_id, group_id){
	var grupos, action, ele;
	
	msggrupos = document.getElementById('msggrupos');
	ele = document.getElementById('grupos['+group_id+']');
	if(ele.checked){
		action = 'setGroup';
	} else {
		action = 'unsetGroup';
	}
	ajax = nuevoAjax();
	ajax.open("GET", "index2.php?com=usuarios&do=ajax&tpl=clean&act="+action+"&uid="+usuario_id+"&gid="+group_id, true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			msggrupos.innerHTML = ajax.responseText
		}
	}
	ajax.send(null);
	
	location.href="index2.php?com=usuarios&do=view&uid="+usuario_id;
}

/**
 * @desc combo con tutorias de un tutor
 */
function getCursosTutor()
{
    var tutor;
	
    cursoscombo = document.getElementById('cursoscombo');
	tutor = document.getElementById('tutor').value;
	action = "getCursosTutor";
	
	ajax = nuevoAjax();
	ajax.open("GET", "index2.php?com=asistencia&do=ajax&tpl=clean&act="+action+"&tutor="+tutor, true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			cursoscombo.innerHTML = ajax.responseText;
		}
	}
	ajax.send(null);
}

/**
 * @desc combo con tutorias de un tutor
 */
function getCursosPrograma()
{
    var pid;
	
    cursoscombo = document.getElementById('cursoscombo');
	pid = document.getElementById('programas_id').value;
	action = "getCursosPrograma";
	
	ajax = nuevoAjax();
	ajax.open("GET", "index2.php?com=usuarios&do=ajax&tpl=clean&act="+action+"&pid="+pid, true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			cursoscombo.innerHTML = ajax.responseText;
		}
	}
	ajax.send(null);
}

/**
 * @desc combo con tutorias de un tutor
 */
function getCatedras()
{
    var programas_id, semestre;
	
    catedrascombo = document.getElementById('catedrascombo');
	programas_id = document.getElementById('programas_id').value;
	semestre = document.getElementById('semestre').value;
	
	action = "getCatedras";
	
	ajax = nuevoAjax();
	ajax.open("GET", "index2.php?com=cursos&do=ajax&tpl=clean&act="+action+"&programa_id="+programas_id+"&semestre="+semestre, true);
	ajax.onreadystatechange=function(){
		if(ajax.readyState==4){
			catedrascombo.innerHTML = ajax.responseText;
		}
	}
	ajax.send(null);
}

