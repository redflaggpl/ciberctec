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
            <table width="100%" cellspacing="0" cellpadding="0">
			    <tr>
				  <th colspan="2">Evaluación de {$tutor}</th>
				</tr>
				<tr>
				   <td class="headlines" valign="top">Asignatura</td>
				   <td><strong>{$curso}</strong></td>
				</tr>
				<tr>
				   <td class="headlines" valign="top">Su concepto del tutor es:</td>
				   <td><strong>{$concepto}</strong></td>
				</tr>
				<tr>
				   <td colspan="2"><hr size="1"></td>
				</tr>
				<tr>
				<td colspan="2">
				<table class="adminlist">
				    <tr>
					  <th class="title">Pregunta</th>
				      <th class="title">Respuesta</th>
				    </tr>
				   {section name=row loop=$data}
				    <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
				       onmouseout="rowOutEffect(this)">
				      <!--<td class="title">{$data[row].id}</th>-->
				      <td class="title">{$data[row].pregunta}:</th>
				      <td class="title"><strong>{$data[row].respuesta}</strong></th>
				    </tr>
				    {sectionelse}
				    <tr>
				      <td colspan="7">No se han registrado cursos</td>
				    </tr>
				    {/section}
				  </table>
				</td>
				</tr>
			   </table>
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