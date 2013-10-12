<br />
{if $msg neq ''}
<div class="message">
  {$msg}
</div>
{/if}
<div align="center" class="centermain">
  <div class="main">
    {literal}
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
	    submitform( pressbutton );
	    return;
	}
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

	// do field validation
	if (trim(form.sdoctypes.value) == "") {
	    alert( "Debe ingresar al menos un Tipo de Documento." );
	} else if (trim(form.ssteps.value) == "") {
	    alert( "Debe ingresar al menos un Paso." );
	} else if (form.sitemspp.value == "") {
            alert( "Ingrese el Numero de Items por pagina en listados.");
	} else {
	    submitform( pressbutton );
	}
    }
    </script>
    {/literal}
    <form action="{$smarty.server.SCRIPT_NAME}" method="post" name="adminForm">
    <table class="adminheading">
    <tr>
      <th class="setupedit">
	Editar Configuraci&oacute;n Global 
      </th>
    </tr>
    </table>
    <table cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td width="50%" valign="top">
	<table width="100%" class="adminform">
	<tr>
	  <td>
	    <table cellspacing="0" cellpadding="0" width="100%">
	    <tr>
	      <th colspan="4">
		Variables de Ambiente
	      </th>
	    </tr>
	    <tr>
	      <td width="150" valign="top">Tipos de Documentos:<br />
	        <i>Ingrese un tipo de documento despues de otro, separados por coma</i></td>
	      <td nowrap><textarea class="text_area" name="sdoctypes" rows="5" cols="50">{$sdoctypes}</textarea></td>
	    </tr>
	    <tr>
	      <td valign="top">Pasos:<br />
		<i>Ingrese un paso despues de otro, separados por coma</i></td>
	      <td><textarea class="text_area" name="ssteps" rows="5" cols="50">{$ssteps}</textarea></td>
	    </tr>
	    <tr>
	      <td>Items por p&aacute;gina:</td>
	      <td><input class="text_area" type="text" name="sitemspp" size="5" maxlength="2" value="{$sitemspp}" /></td>
	    </tr>
	    </table>
	  </td>
	</tr>
	</table>
      </td>
    </tr>
    </table>
    <input type="hidden" name="id" value="{$id}" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="action" value="setup" />
    </form>
  </div>
</div>
<div id="break"></div>
</div>

