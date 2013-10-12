{literal}
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$("#adminForm").validate();
		});
	</script>
{/literal}

<div align="center" class="centermain"> 
	<div class="main">
<table class="adminheading">
    <tr>
      <th class="cursos">
	Nueva Catedra
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
	               action="index2.php?com=catedras&do=view">
		          <table width="100%" cellspacing="0" cellpadding="0">
		            <tr>
		              <th colspan="4">Detalles</th>
		            </tr>
		            <tr>
			            <td  class="headlines">Nombre</td>
			              <td><input type="text" name="nombre" id="nombre" class="required" value="{$nombre}">
			            <td>
			            <td  class="headlines"></td>
			            <td></td>
		            </tr>
		            <tr>
			            <td  class="headlines">Programa</td>
			              <td>
			                  <select name="programas_id" 
			                          id="programas_id" class="required" onchange="getCatedras();">
			                          <option value="">--</option>
								{html_options options=$programas selected=$programas_id}
							  </select> 
			              </td>
			            <td  class="headlines"></td>
			            <td></td>
		            </tr>
		            <tr>
			            <td class="headlines">Semestre: </td>
			             <td>
			                <select name="semestre" id="semestre" class="required" ">
								<option value="">--</option>
					  			{html_options options=$semestres selected=$semestre }
							  </select> 
						 </td>
			              <td  class="headlines">Horas</td>
			              <td><input type="text" id="horas" name="horas" class="required" size="2" value="{$horas}"></td>
		            </tr>
		            <tr>
			              <td class="headlines">Estado</td>
			              <td>
			                   <select name="estado" id="estado" class="required">
								<option value="">--</option>
					  			{html_options options=$estados selected=$estado }
							  </select>
			              </td>
			              <td></td>
			              <td></td>
		            </tr>
		            <tr>
		              <td class="headlines">
		                  <input type="hidden" name="do_edit" value="do" />
		              </td>
		              <td>
		              	<input type="submit" name="Submit" value="Enviar" /> 
		              	<input type="button" name="Cancelar" value="Cancelar" onClick="location.href='index2.php?com=catedras'">
		              </td>
		              <td><input type="hidden" name="cid" value="{$cid}" /> </td>
		              <td></td>
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
	    <h3>Tenga en cuenta</h3>
	    <p>Las catedras son diferentes a las cursos, estas deben crearse una sola vez y son requisito para la posterior creación de cursos</p>
	  </div>
	  <!-- fin tab info -->
		   </div><!-- cierre pestañas -->
		</td>
	</tr>
</table>
</div>
</div>