{literal}
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/popup.js" type="text/javascript"></script>  	
{/literal}
<div align="center" class="centermain"> 
	<div class="main">
	<div id="msg"></div>
<table class="adminheading">
    <tr>
      <th class="comlist">
		Cursos
      </th>
   </tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td width="50%" valign="top">
      <table width="100%" class="adminform">
        <tr>
          <td>
            <form name="adminForm" id="adminForm" method="post" action="index2.php?com=comunicados&do=new">
 			  <table width="100%" cellspacing="0" cellpadding="0">
			    <tr>
				  <th colspan="6">Detalles</th>
				</tr>
				<tr>
				   <td class="headlines">Descripción</td>
				   <td>{$descrip}</td>
				   <td class="headlines"></td>
				   <td></td>
				</tr>
				<tr>
					<td class="headlines">Grado</td>
					<td>
					    
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td class="headlines">Adjuntos</td>
					<td>
					   
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
				  <td class="headlines" colspan="4">Mensaje</td>
				</tr>
				<tr>
				  <td colspan="4">
				    {$mensaje}
				  </td>
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
	         <table width="90%" cellpadding="5" cellspacing="0" border="0">
	         	<tr>
				  <td class="headlines">Fecha Enviado</td>
				  <td>{$fecha}</td>
				  <td class="headlines">Fecha vencimiento</td>
				  <td>{$fecvence}</td>
				</tr>
				<tr>
				   <td class="headlines">CategorÃ­a</td>
				   <td>{$categoriamensaje}</td>
				   <td class="headlines">Tipo</td>
				   <td>{$tipomensaje}</td>
				</tr>
	         </table>
		  </div>
		 <!-- fin tab +info -->
	  </div><!-- cierre tabs -->
    </td>
  </tr>
</table>
</div>
</div><br></br>