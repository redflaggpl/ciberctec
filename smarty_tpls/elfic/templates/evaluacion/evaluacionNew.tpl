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
      <th class="questsnew">
		Evaluación de Tutores: 
      </th>
    </tr>
    </table>
<table cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td width="70%" valign="top">
      <table width="100%" class="adminform">
        <tr>
          <td>
            <form name="adminForm" id="adminForm" method="post" action="index2.php?com=evaluacion&do=set">
 			  <table width="100%" cellspacing="0" cellpadding="0">
			    <tr>
				  <th colspan="2">Evaluación de {$tutor}</th>
				</tr>
				<tr>
				   <td class="headlines" valign="top">Asignatura</td>
				   <td>{$curso}</td>
				</tr>
				<tr>
				   <td class="headlines" valign="top">Su concepto del tutor es:</td>
				   <td>
				       <select name="concepto_tutor" id="concepto_tutor" class="required">
				           <option value="">--</option>
				           <option value="4">Excelente</option>
				           <option value="3">Bueno</option>
				           <option value="2">Regular</option>
				           <option value="1">Malo</option>
				       </select>
                   </td>
				</tr>
				<tr>
				   <td colspan="2"><hr size="1"></td>
				</tr>
				<tr>
				<td colspan="2">
				<table class="adminlist">
				   {section name=row loop=$data}
				    <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
				       onmouseout="rowOutEffect(this)">
				      <td class="title">{$data[row].id}</th>
				      <td class="title">{$data[row].pregunta}</th>
				    </tr>
				    <tr>
				       <td colspan="2">
				           <!--<select name="respuesta[{$data[row].id}]" class="required">
				               <option value="">--</option>
				               <option value="1">Si</option>
				               <option value="0">No</option>
				           </select>-->
				           Si <input type="radio" name="respuesta[{$data[row].id}]" value="1" class="required">
				           No <input type="radio" name="respuesta[{$data[row].id}]" value="0" >
				       </td>
				    </tr>
				    {sectionelse}
				    <tr>
				      <td colspan="7">No se han registrado cursos</td>
				    </tr>
				    {/section}
				  </table>
				</td>
				</tr>
			     <tr>
			       <td>
			         <input type="hidden" id="do_save" name="do_save" value="do">
			         <input type="hidden" id="tutor_id" name="tutor_id" value="{$tutor_id}">
			         <input type="hidden" id="curso_id" name="curso_id" value="{$cid}">
			       </td>
			       <td>
			           <input type="submit" name="Submit" value="Enviar" />
			           <input type="button" name="Cancelar" value="Cancelar"
			               onClick="location.href='index2.php?com=evaluacion'"></td>
			     </tr>
			   </table>
		     </form>
	       </td>
	     </tr>
	  </table>
	</td>
    <td width="1%">&nbsp;</td>
    <td width="29%" valign="top">
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
	         Directrices a tener en cuenta durante la elaboración de la evaluación
		  </div>
		 <!-- fin tab +info -->
	  </div><!-- cierre tabs -->
    </td>
  </tr>
</table>
</div>
</div><br></br>