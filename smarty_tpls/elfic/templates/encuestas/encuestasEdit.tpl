{literal}
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
	    $(document).ready(function() {
    	$("#adminForm").validate();
    	$("#adminForm1").validate();
		});
	</script>
	<script src="js/popup.js" type="text/javascript"></script>  	
{/literal}
{literal}
<script type="text/javascript">

var numero = 0;



// Funciones comunes

c= function (tag) { // Crea un elemento

   return document.createElement(tag);

}

d = function (id) { // Retorna un elemento en base al id

   return document.getElementById(id);

}

e = function (evt) { // Retorna el evento

   return (!evt) ? event : evt;

}

f = function (evt) { // Retorna el objeto que genera el evento

   return evt.srcElement ?  evt.srcElement : evt.target;

}



addField = function () {

   container = d('respuestas');
   span = c('SPAN');
   span.className = 'required';
   span.id = 'respuestas' + (++numero);
   field = c('INPUT');   
   field.name = 'respuestas[]';
   field.type = 'text';
   field.size = '80';
   field.maxlenght = '255';
   a = c('A');
   a.name = span.id;
   a.href = '#';
   a.onclick = removeField;
   a.innerHTML = 'Quitar';
   span.appendChild(field);
   span.appendChild(a);
   container.appendChild(span);
}

removeField = function (evt) {

   lnk = f(e(evt));
   span = d(lnk.name);
   span.parentNode.removeChild(span);

}
</script>

{/literal}
<div align="center" class="centermain"> 
	<div class="main">
<table class="adminheading">
    <tr>
      <th class="questsnew">
		Edición Encuesta
      </th>
    </tr>
    </table>
<table cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td width="50%" valign="top">
      <table width="100%" class="adminform">
        <tr>
          <td>
            <form name="adminForm" id="adminForm" 
                  enctype="multipart/form-data" 
                  method="post" action="index2.php?com=encuestas&do=edit">
 			  <table width="100%" cellspacing="0" cellpadding="0">
			    <tr>
				  <th colspan="6">Edición de  Encuesta</th>
				</tr>
				<tr>
				   <td class="headlines" valign="top">Titulo</td>
				   <td><input name="titulo" type="text" id="titulo" size="30" maxlength="90" 
				              class="required" value="{$titulo}"/></td>
				   <td></td>
				   <td></td>
				</tr>
				<tr>
				   <td class="headlines" valign="top">Observaciones</td>
				   <td><textarea name="observaciones" id="observaciones" 
				                 class="required">{$observaciones}</textarea></td>
				   <td></td>
				   <td></td>
				</tr>
				<tr>
				   <td class="headlines">Publicada</td>
				   <td>
				       <select name="publicado" id="publicado" class="required">
				        <option value="">--</option>
			            {html_options options=$publicado selected=$sel_pub}
			           </select>
				   </td>
			     <tr>
			       <td>
			         <input type="hidden" id="do_save" name="do_save" value="do">
			         <input type="hidden" id="uid" name="uid" value="{$uid}">
			         <input type="hidden" id="eid" name="eid" value="{$eid}">
			       </td>
			       <td>
			           <input type="submit" name="Submit" value="Enviar" />
			           <input type="button" name="Cancelar" value="Cancelar"
			               onClick="location.href='index2.php?com=encuestas'"></td>
			       <td></td>
			       <td>&nbsp;</td>
			     </tr>
			   </table>
		     </form>
	       </td>
	     </tr>
	  </table>
	  <table width="100%" class="adminform">
        <tr>
          <td>
            <table width="100%" cellspacing="0" cellpadding="0">
			    <tr>
				  <th colspan="6">Preguntas asociadas a la encuesta</th>
				</tr>
				<tr>
				   <td class="headlines" valign="top">{$data}</td>
				</tr>
			   </table>
	       </td>
	     </tr>
	  </table>
	</td>
    <td width="1%">&nbsp;</td>
    <td width="49%" valign="top">
	  <div class="tab-page" id="pdetails-pane">
	    {literal}
		  <script type="text/javascript">
		    var tabPane1 = new WebFXTabPane( document.getElementById( "pdetails-pane" ), 1 );
		  </script>
		{/literal}
		<!-- incia tab +info -->
	      <div class="tab-page" id="preguntas-page">
	       <h2 class="tab">Preguntas</h2>
	         {literal}
	           <script type="text/javascript">
	             tabPane1.addTabPage( document.getElementById( "preguntas-page" ) );
	           </script>
	         {/literal}
	         <form name="adminForm1" id="adminForm1" 
                  enctype="multipart/form-data" 
                  method="post" action="index2.php?com=encuestas&do=addpregunta">
                  <table width="100%" class="adminform">
			        <tr>
			          <td>
		                  <table width="100%" cellspacing="0" cellpadding="0">
						    <tr>
							  <th colspan="2">Agregar pregunta</th>
							</tr>
							<tr>
							   <td class="headlines" valign="top">Pregunta</td>
							   <td>
							       <input name="pregunta" type="text" id="pregunta" size="100" maxlength="255" 
							              class="required" value=""/>
							   </td>
							</tr>
					      </table>
					      <table width="100%" cellspacing="0" cellpadding="0">
						    <tr>
							  <th colspan="2">Opciones de respuesta</th>
							</tr>
							<tr>
							   <td class="headlines" valign="top">
							       <a href="#" onclick="addField()" accesskey="5" class="actionattach">Añadir Opción</a>
				                   <div id="respuestas"></div>
				               </td>
							   <td></td>
							</tr>
							<tr>
							  <td>
							   <input type="hidden" name="eid" id="eid" value="{$eid}">
							  </td>
							  <td>
							      <input type="submit" name="Submit" value="Enviar" />
							  </td>
					      </table>
			         </td>
			      </tr>
				</table>
             </form>

		  </div>
		 <!-- fin tab +info -->
	  </div><!-- cierre tabs -->
    </td>
  </tr>
</table>
</div>
</div><br></br>