<div align="center" class="centermain"> 
	<div class="main">
<table class="adminheading">
<table cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td width="50%" valign="top">
      <table width="100%" class="adminform">
        <tr>
          <th>Reportes</th>
        </tr>
        <tr>
          <td>&raquo <a href="index2.php?com=reportes&do=asistencia">Horas registradas frente a horas programadas, por curso</a></td>
        </tr>
        <tr>
          <td>&raquo <a href="index2.php?com=reportes&do=evaluacion">Evaluación general de un tutor</a></td>
        </tr>
      </table>
	  </td>
      <td width="1%">&nbsp;</td>
      	<td width="49%" valign="top">
		<!--  open tabs -->
		<div class="tab-page" id="pdetails-pane">
		  {literal}
		  <script type="text/javascript">
		    var tabPane1 = new WebFXTabPane( document.getElementById( "pdetails-pane" ), 1 );
		  </script>
		  {/literal}
		  	<!-- tab info -->
		  	<div class="tab-page" id="resumen-page">
		    	<h2 class="tab">Resumen</h2>
			    {literal}
			    <script type="text/javascript">
			      tabPane1.addTabPage( document.getElementById( "resumen-page" ) );
			    </script>
			    {/literal}
			   
			 </div>
			 <!-- end tab info -->
		 </div>
		 <!-- cierre tabs-->
		</td>
	</tr>
</table>
</div>
</div><br></br>
   