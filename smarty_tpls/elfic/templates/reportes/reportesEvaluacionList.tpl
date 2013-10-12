{literal}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.superbox-min.js"></script>

  <link rel="stylesheet" href="css/jquery.superbox.css" type="text/css" />
<script type='text/javascript'>
$(function(){
$.superbox();
});
</script>
{/literal}
<div align="center" class="centermain">
  <div class="main">
    <table class="adminheading">
    <tr>
      <th class="reportes">
        Reporte de Evalualación a Docentes:
      </th>
      <th>
            <a href="index2.php?com=reportes&do=listtoexcel">
        	    <img src="images/iconos/excel.png" border="0">
            </a>
      </th>
      <th width="300">
          <table width="300">
      	<form id="adminForm" action="{$smarty.server.SCRIPT_NAME}?com=reportes&do=evaluacion" method="post" name="adminForm">
    		<tr>
    			<td>Periodos: 
    			   <select name="periodo_id" id="periodo_id" class="required">
					<option value="">--</option>
		  			{html_options options=$periodos }
				  </select> 
    			</td>
    			<td>Nombre: <input name="search" type = "text" id="search" value=""></td>
    		 	<td><input name="do_search" type="submit" id="do_search" value="Buscar"/></td>
    		 </tr>
    	</form>
    	</table>
      </th>
    </tr>
    </table>
    <table class="adminlist">
    <tr>
      <th class="title">#</th>
      <th class="title">Id</th>
      <th class="title">Tutor</th>
      <th class="title">Concepto</th>
      <th class="title">Nº Evaluaciones</th>
    </tr>
   {section name=row loop=$data}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" 
       onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$data[row].tutor_id}</td>
      <td>{$data[row].tutor}</td>
      <td>{$data[row].concepto}</td>
      <td>{$data[row].numeval}</td>
      </td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="4">No hay registros</td>
    </tr>
    {/section}
    </table>
   
    <table class="adminlist">
		<tr>
			<th align="center" colspan="2">{$anchors}</th>
		</tr>
		<tr>
			<th align="center" colspan="2">{$total}</th>
		</tr>
	</table>
  </div>
</div>
<div id="break"></div>
</div>

