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
      <th class="agendas">
	    Cargar Agenda
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
               action="index2.php?com=cursos&do=cargarAgenda" enctype="multipart/form-data">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <th colspan="6">Detalles</th>
            </tr>
            <tr>
            <td class="headlines">Tutor: </td>
             <td>
             {if $tutores neq 'false'}
                <select name="tutor_id" id="tutor_id" class="required">
					<option value="">--</option>
		  			{html_options options=$tutores selected=$tutor_id }
				  </select> 
			 {else}
			    {$tutor}
			    <input type="hidden" value="{$tutor_id}">
			 {/if}
			 </td>
              <td  class="headlines">Curso</td>
              <td>
                  <select name="curso_id" id="curso_id" class="required">
					<option value="">--Seleccione--</option>
		  			{html_options options=$cursos selected=$curso }
				  </select> 
              </td>
            <tr>
            <tr>
                <td class="headlines">Cargar PDF</td>
	            <td colspan="3">
	            <input id="agenda" type="file" name="agenda" />
	            </td>
            </tr>
              <td class="headlines" valign="top">Comentarios</td>
              <td colspan="3">
                  <textarea id="comentarios" cols="50" rows="10" ></textarea>
              </td>
            </tr>
            
            <tr>
              <td class="headlines">
                  <input type="hidden" name="do_save" value="do" />
              </td>
              <td><input type="submit" name="Submit" value="Enviar" /> <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='index2.php?com=cursos'"></td>
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
	  </div>
	  <!-- fin tab info -->
		   </div><!-- cierre pestañas -->
		</td>
	</tr>
</table>
</div>
</div>