{literal}
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$("#adminForm").validate();
    	$("#adminForm8").validate();
    	$.validator.setDefaults({
		//submitHandler: function() { alert("submitted!"); }
		});
 
		$("#adminForm2").validate();
			
			// validate signup form on keyup and submit
			$("#adminForm2").validate({
				rules: {
					password: {
						required: true,
						minlength: 5
					},
					confirm_password: {
						required: true,
						minlength: 5,
						equalTo: "#password"
					}
				},
				messages: {
					password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long"
					},
					confirm_password: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						equalTo: "Please enter the same password as above"
					}
				}
			});
			
			// check if confirm password is still valid after password changed
			$("#password").blur(function() {
				$("#confirm_password").valid();
			});
		});
	</script>
	<script src="js/popupSmall.js" type="text/javascript"></script>
{/literal}
{literal}
    <script language="javascript" type="text/javascript">
    

    // This function gets called when the end-user clicks on some date.
    function selected(cal, date) {
	cal.sel.value = date; // just update the date in the input field.
	if (cal.dateClicked && cal.sel.id == "nonexistent")
	// if we add this call we close the calendar on single-click.
	// just to exemplify both cases, we are using this only for the 1st
	// and the 3rd field, while 2nd and 4th will still require double-click.
	cal.callCloseHandler();
    }

    // And this gets called when the end-user clicks on the _selected_ date,
    // or clicks on the "Close" button.  It just hides the calendar without
    // destroying it.
    function closeHandler(cal) {
	cal.hide();                        // hide the calendar
	//  cal.destroy();
	_dynarch_popupCalendar = null;
    }

    // This function shows the calendar under the element having the given id.
    // It takes care of catching "mousedown" signals on document and hiding the
    // calendar if the click was outside.
    function showCalendar(id, format, showsTime, showsOtherMonths) {
	var el = document.getElementById(id);
	if (_dynarch_popupCalendar != null) {
	    // we already have some calendar created
	    _dynarch_popupCalendar.hide();                 // so we hide it first.
	} else {
	    // first-time call, create the calendar.
	    var cal = new Calendar(1, null, selected, closeHandler);
	    // uncomment the following line to hide the week numbers
	    // cal.weekNumbers = false;
	    if (typeof showsTime == "string") {
		cal.showsTime = true;
		cal.time24 = (showsTime == "24");
	    }
	    if (showsOtherMonths) {
		cal.showsOtherMonths = true;
	    }
	    _dynarch_popupCalendar = cal;                  // remember it in the global var
	    cal.setRange(1900, 2070);        // min/max year allowed.
	    cal.create();
	}
	_dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
	_dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
	_dynarch_popupCalendar.sel = el;                 // inform it what input field we use

	// the reference element that we pass to showAtElement is the button that
	// triggers the calendar.  In this example we align the calendar bottom-right
	// to the button.
	_dynarch_popupCalendar.showAtElement(el, "Br");        // show the calendar

	return false;
    }
    </script>
    {/literal}

<div align="center" class="centermain"> 
	<div class="main">
<table class="adminheading">
    <tr>

      <th class="usersnew">
	      Edición de Usuario {$login} 
      </th>
    </tr>
    </table>
<table cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td width="50%" valign="top">
      <table width="100%" class="adminform">
        <tr>
          <td>
         <form name="adminForm" id="adminForm" method="post" 
               action="index2.php?com=usuarios&do=view">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <th colspan="6">Datos del Usuario</th>
            </tr>
            <tr>
              <td class="headlines">Nombres</td>
              <td><input name="nombres" type="text" id="nombres" size="30" 
                  maxlength="20" class="required" value="{$nombres}"/></td>
              <td class="headlines">Apellidos</td>
              <td><input name="apellidos" type="text" id="apellidos" size="30" 
                  maxlength="20" value="{$apellidos}"/></td>
            </tr>
           <tr>
            <td class="headlines">Login</td>
              <td><input name="login" type="text" id="login" size="30" maxlength="50" 
                  class="required" value="{$login}"></td>
              <td class="headlines">Email</td>
              <td><input name="email" type="text" id="email" size="30" maxlength="50" 
                  class="required email" value="{$email}">
              </td>
              
            </tr>
           <tr>
              <td class="headlines">Activo</td>
              <td>
              	<select name="activo" id="activo" class="required">
					<option value="">--Seleccione--</option>
		  			{html_options options=$activo_combo selected=$activo }
					</select> 
              </td>
              <td class="headlines">Administrador</td>
              <td>
              	<select name="esadmin" id="esadmin" class="required">
					<option value="">--Seleccione--</option>
		  			{html_options options=$esadmin_combo selected=$esadmin}
					</select> 
              </td>
            </tr>
            <tr>
              <td class="headlines">
              	<input type="hidden" name="do_edit" value="do" />
              	<input type="hidden" name="uid" value="{$uid}" />
              </td>
              <td><input type="submit" name="Submit" value="Enviar" /> <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='index2.php?com=usuarios'"></td>
              <td></td>
              <td>&nbsp;</td>
            </tr>
          </table>
           </form>
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
	  <!--  inicio tab info -->
	  <div class="tab-page" id="info-page">
	    <h2 class="tab">Información</h2>
	    {literal}
	    <script type="text/javascript">
	      tabPane1.addTabPage( document.getElementById( "info-page" ) );
	    </script>
	    {/literal}
	   <p>Fecha de Creación: {$creado}</p>
	   <p>Último Ingreso: {$ultimoingreso}</p>
	  </div>
	  <!-- fin tab info -->
	  <!--  inicio tab permisos -->
	  <div class="tab-page" id="permisos-page">
	    <h2 class="tab">Grupos</h2>
	    {literal}
	    <script type="text/javascript">
	      tabPane1.addTabPage( document.getElementById( "permisos-page" ) );
	    </script>
	    {/literal}
	    
        <div id="msggrupos" class="message"></div>
	        <table width="100%" class="adminform">
                <tr>
	              <th colspan="6">Agregue o retire a un usuario de un grupo</th>
	            </tr>
	            <tr>
	              <td>
	    			{$grupos}
	    		  </td>
	        </table>
	   </div>
		 <!-- fin tab permisos -->
	  {if $estudiante eq 1}
	  <!--  inicio tab cursos -->
	  <div class="tab-page" id="cursos-page">
	    <h2 class="tab">Cursos</h2>
	    {literal}
	    <script type="text/javascript">
	      tabPane1.addTabPage( document.getElementById( "permisos-page" ) );
	    </script>
	    {/literal}
        <form name="adminForm2" id="adminForm2" method="POST" action="{$smarty.server.SCRIPT_NAME}?com=usuarios&do=asignarcurso">
	    
	    <table border="0" cellspacing="1" cellpadding="3">
		   <tr>
		    <td>Programa: </td><td>
		    <select name="programas_id" id="programas_id" class="required" onchange="getCursosPrograma();">
			  	<option value="">-- Seleccione --</option>
			  	{html_options options=$programas}
			</select> 
			</td>
			<td>Curso: </td><td>
			<div id="cursoscombo">
		    
			</div>
			</td>
			<tr><td></td><td>
				<input name="enviar" type="submit" id="enviar" value="Asignar" ;/>
				<input name="uid" type="hidden" id="uid" value="{$uid}" />
			</td>
		   </tr>
		</table>
		</form>
		<br>
		<div id = "divcursos">
		<table class="adminlist">
			<tr>
			   <th>Curso</th>
			   <th>Acciones</th>
			</tr>
		    <tr>
			    {section name=row loop=$cursos}
			   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
			       onmouseout="rowOutEffect(this)">
			      <td>{$cursos[row].curso}</td>
			      <td><a href="index2.php?com=usuarios&do=unsetcurso&cursos_id={$cursos[row].id}&uid={$uid}">Borrar</a></td>
			    </tr>
			    {sectionelse}
			    <tr>
			      <td colspan="7">No se han registrado cursos</td>
			    </tr>
			    {/section} 
		    </tr>
	    </table>
	    </div>
	    </div>
	  <!-- fin tab cursos -->
	  {/if}
	  {if $coordinador eq 1}
	  <!--  inicio tab programas -->
	  <div class="tab-page" id="programas-page">
	    <h2 class="tab">Programas</h2>
	    {literal}
	    <script type="text/javascript">
	      tabPane1.addTabPage( document.getElementById( "permisos-page" ) );
	    </script>
	    {/literal}
        <form name="adminForm2" id="adminForm2" method="POST" action="{$smarty.server.SCRIPT_NAME}?com=usuarios&do=asignarprograma">
	    
	    <table border="0" cellspacing="1" cellpadding="3">
		   <tr>
		    <td>Programa: </td><td>
		    <select name="programa_id" id="programa_id" class="required">
			  	<option value="">-- Seleccione --</option>
			  	{html_options options=$programas}
			</select> 
			</td>
			<td>
				<input name="enviar" type="submit" id="enviar" value="Asignar" ;/>
				<input name="uid" type="hidden" id="uid" value="{$uid}" />
			</td>
		   </tr>
		</table>
		</form>
		<br>
		<div id = "divcursos">
		<table class="adminlist">
			<tr>
			   <th>Programa</th>
			   <th>Acciones</th>
			</tr>
		    <tr>
			    {section name=row loop=$progdata}
			   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
			       onmouseout="rowOutEffect(this)">
			      <td>{$progdata[row].programa}</td>
			      <td><a href="index2.php?com=usuarios&do=unsetprograma&programas_id={$progdata[row].id}&uid={$uid}">Borrar</a></td>
			    </tr>
			    {sectionelse}
			    <tr>
			      <td colspan="7">No se ha asignado un programa a este coordinador</td>
			    </tr>
			    {/section} 
		    </tr>
	    </table>
	    </div>
	    </div>
	  <!-- fin tab cursos -->
	  {/if}
		   <div class="tab-page" id="budget-page">
		    <h2 class="tab">Contraseña</h2>
		    {literal}
		    <script type="text/javascript">
		      tabPane1.addTabPage( document.getElementById( "passwd-page" ) );
		    </script>
		    {/literal}
		    <table width="100%" class="adminform">
        <tr>
          <td>
          <form name="adminForm2" id="adminForm2" method="post" action="{$smarty.server.SCRIPT_NAME}?com=usuarios&do=chpass&uid={$id}"> 
	      	<table width="100%" cellspacing="0" cellpadding="0">
	            <tr>
	              <th colspan="6">Contraseña</th>
	            </tr>
	            <tr>
	              <td><label for="password">Contraseña</label></td>
	              <td><input id="password" name="password" type="password" /> </td>
	              <td></td>
	              <td></td>
	            </tr>
	            <tr>
	              <td><label for="confirm_password">Confirmar Contraseña</label> </td>
	              <td><input id="confirm_password" name="confirm_password" type="password" equalTo="#password"/></td>
	              <td></td>
	              <td></td>
	            </tr>
	           	<tr>
	              <td><input type="hidden" name="uid" value="{$uid}" /></td>
	              <td><input type="submit" name="Submit" value="Enviar" /></td>
	              <td></td>
	              <td></td>
	            </tr>
	          </table>
	          </form>
	         </td>
	        </tr>
	       </table>
		    </div>
		   </div><!-- cierre pestañas -->
		</td>
	</tr>
</table>
</div>
</div>