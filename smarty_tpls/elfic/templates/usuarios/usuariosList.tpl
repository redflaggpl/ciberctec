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
      <th class="usersnew">
        Usuarios: 
      </th>
      <th width="550">
      	<table width="400">
      	<form id="adminForm" action="{$smarty.server.SCRIPT_NAME}?com=usuarios&do=search" method="post" name="adminForm">
    		<tr>
    			<td>Nombre: <input name="search" type = "text" id="search" value=""></td>
    		 	<td>Tipo: 
    		 	<select name="grupo_id" id="grupo_id">
    		 	<option value="">Seleccione</option>
    				{html_options options=$grupos selected=$grupo_id}
    		 	</select>
    		 	</td>
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
      <th class="title">Nombre</th>
      <th class="title">Email</th>
      <th class="title">Registro</th>
      <th class="title">Modificado</th>
      <th class="title">&Uacute;ltima Visita</th>
      <th class="title">Estado</th>
      <th class="title">Administrador</th>
    </tr>
   {section name=row loop=$u}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
       onmouseout="rowOutEffect(this)" onclick="document.location.href='?com=usuarios&do=view&uid={$u[row].id}'">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$u[row].id}</td>
      <td>{$u[row].nombres} {$u[row].apellidos}</td>
      <td>{$u[row].email}</td>
      <td>{$u[row].creado}</td>
      <td>{$u[row].modificado}</td>
      <td>{$u[row].ultimoingreso}</td>
      <td>{$u[row].activo}</td>
      <td>{$u[row].esadmin}</td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="8">No existen usuarios</td>
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
<div id="break"></div>
</div>

