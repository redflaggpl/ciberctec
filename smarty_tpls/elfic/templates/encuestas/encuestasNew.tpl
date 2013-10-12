{literal}
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#adminForm").validate({ 
				rules: {
					urlfoto: { /*id del campo que se aplica la regla*/
					accept: "jpg|png" /*extensiones aceptadas*/
					}
				}
			});
		});
	</script>
	<script src="js/popup.js" type="text/javascript"></script>  	
{/literal}
<div align="center" class="centermain"> 
	<div class="main">
<table class="adminheading">
    <tr>
      <th class="questsnew">
		Encuesta de Intención de Voto
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
                  method="post" action="index2.php?com=encuestas&do=new">
 			  <table width="100%" cellspacing="0" cellpadding="0">
			    <tr>
				  <th colspan="6">Nueva Encuesta</th>
				</tr>
				<tr>
				   <td class="headlines" valign="top">Teléfono</td>
				   <td><select name="telefono" id="telefono" class="required" onChange="telefonoEncuesta({$eid})">
				        <option value="">--</option>
			            {html_options options=$telefono}
			           </select></td>
				   <td><div id="mensajeTel"></div></td>
				   <td></td>
				</tr>
				<tr>
				   <td class="headlines" valign="top">Nombre</td>
				   <td><input name="nombre" type="text" id="nombre" size="30" maxlength="90" 
				              class="required" value=""/></td>
				   <td></td>
				   <td></td>
				</tr>
				<tr>
				   <td colspan="4"><hr size="1"></td>
				</tr>
				{$data}
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
	      <div class="tab-page" id="info-page">
	       <h2 class="tab">+ Info</h2>
	         {literal}
	           <script type="text/javascript">
	             tabPane1.addTabPage( document.getElementById( "info-page" ) );
	           </script>
	         {/literal}
	         Directrices a tener en cuenta durante la elaboración de la encuesta
		  </div>
		 <!-- fin tab +info -->
	  </div><!-- cierre tabs -->
    </td>
  </tr>
</table>
</div>
</div><br></br>