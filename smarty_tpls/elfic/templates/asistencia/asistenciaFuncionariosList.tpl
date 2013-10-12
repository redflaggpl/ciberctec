<br />
{if $msg neq ''}
<div class="message">
  {$msg}
</div>
{/if}
{literal}
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
      <th class="asistencia">
        Control de Asistencia Funcionarios
      </th>
      <th width="400">
          <table width="400" >
      	    <tr>
      	        <td>
      	           <form id="searchform" action="index2.php?com=asistencia&do=list_fun" method="post">
			        Funcionario: <select name="funcionario" id="funcionario">
			           <option value="">--</option>
			            {html_options options=$funcionarios selected=$sel_func}
			        </select>
			        <input type="submit" label="Filtrar" value="filtrar">
			     </form>
      	        </td>
      	    </tr>
    	</table>
    </th>
    </tr>
    </table>
    <table class="adminlist">
    <tr>
      <th class="title">#</th>
       <th class="title">ID</th>
      <th class="title">Funcionario</th>
      <th class="title">Entrada</th>
      <th class="title">Salida</th>
      <th class="title">Comentarios</th>
    </tr>
   {section name=row loop=$lista}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$lista[row].id}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >{$lista[row].funcionario}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >{$lista[row].entrada}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >{$lista[row].salida}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >{$lista[row].comentarios}</td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="8">No hay encuestas disponibles</td>
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
<div id="break">
</div>