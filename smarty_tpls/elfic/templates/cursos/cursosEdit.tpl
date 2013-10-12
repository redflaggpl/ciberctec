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
	    Editando curso: {$catedra}
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
               action="index2.php?com=cursos&do=view">
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <th colspan="6">Detalles</th>
            </tr>
            <tr>
            <td class="headlines">Tutor: </td>
             <td>
                <select name="tutor_id" id="tutor_id" class="required">
					<option value="">--</option>
		  			{html_options options=$tutores selected=$tutor_id}
				  </select> 
			 </td>
              <td  class="headlines">Catedra</td>
              <td>
                  <select name="catedra_id" id="catedra_id" class="required">
					<option value="">--Seleccione--</option>
		  			{html_options options=$catedras selected=$catedra_id}
				  </select> 
              </td>
            </tr>
            <tr>
            <td class="headlines">Grupo: </td>
             <td>
                <select name="grupo" id="grupo" class="required">
					<option value="">--</option>
		  			{html_options options=$grupos selected=$grupo}
				  </select> 
			 </td>
              <td  class="headlines"></td>
              <td>
              </td>
            </tr>
            <tr>
              <td class="headlines">Periodo</td>
              <td>
                  <select name="periodo_id" id="periodo_id" class="required">
					<option value="">--</option>
		  			{html_options options=$periodos selected=$periodo_id}
				  </select> 
              </td>
              <td class="headlines">Día</td>
              <td>
                  <select name="dia" id="dia" class="required">
					<option value="">--</option>
		  			{html_options options=$dias selected=$dia}
				  </select> 
              </td>
            </tr>
            <tr>
              <td class="headlines">Hora</td>
              <td>
                  <select name="hora" id="hora" class="required">
					<option value="">--</option>
		  			{html_options options=$horas selected=$hora }
				  </select> 
              </td>
              <td class="headlines">Estado</td>
              <td>
                   <select name="estado" id="estado" class="required">
					<option value="">--</option>
		  			{html_options options=$estados selected=$estado}
				  </select>
              </td>
            </tr>
            <tr>
              <td class="headlines">
                  <input type="hidden" name="do_edit" value="do" />
                  <input type="hidden" name="cid" value="{$cid}" />
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
	    <h2 class="tab">Agenda</h2>
	    {literal}
	    <script type="text/javascript">
	      tabPane1.addTabPage( document.getElementById( "info-page" ) );
	    </script>
	    
	    {/literal}
	    {if $agenda neq 0}
	    <table width="100%" class="adminform">
			        <tr>
			          <td>
		                  <table width="100%" cellspacing="0" cellpadding="0">
						    <tr>
							  <th>ID</th>
							  <th>Comentarios</th>
							  <th>Fecha de Carga</th>
							  <th>Acciones</th>
							</tr>
							<tr>
							   <td> {$agenda.id}</td>
							   <td> {$agenda.comentarios}</td>
							   <td> {$agenda.fecha}</td>
							   <td>
							       <a href="files/{$cid}.doc" target="_blank">Ver Agenda</a> | 
							       <a href="index2.php?com=cursos&do=borrarAgenda&cid={$cid}">Borrar</a>
							   </td>
							</tr>
					      </table>
			         </td>
			      </tr>
				</table>
	   {else}
	       No se ha cargado agenda para este curso. <a href="index2.php?com=cursos&do=cargarAgenda&cid={$cid}&tutor_id={$tutor_id}">Cargar ahora</a>
	   {/if}
	  </div>
	  <!-- fin tab info -->
		   </div><!-- cierre pestañas -->
		</td>
	</tr>
</table>
</div>
</div>