{literal}
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/popup.js" type="text/javascript"></script>  	
{/literal}
<div align="center" class="centermain"> 
	<div class="main">
		<table class="adminheading">
		    <tr>
		      <th class="questsnew">
				{$titulo}
		      </th>
		    </tr>
		</table>
		<table cellspacing="0" cellpadding="0" width="100%">
		  <tr>
		    <td width="50%" valign="top">
		      <table width="100%" class="adminform">
		        <tr>
		          <td>
		            {$data_res}
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
			         <table width="100%" class="adminform">
				        <tr>
				          <th colspan="2">Detalles</th>
					     </tr>
					     <tr>
				          <td>Fecha de Creaci&oacute;n: </td>
				          <td>{$fecha}</td>
					     </tr>
					     <tr>
				          <td>Creada por: </td>
				          <td>{$usuario}</td>
					     </tr>
					     <tr>
				          <td>Personas encuestadas: </td>
				          <td>{$total_resp}</td>
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