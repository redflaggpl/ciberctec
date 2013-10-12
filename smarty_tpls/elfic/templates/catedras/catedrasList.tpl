<br />
{if $msg neq ''}
<div class="message">
  {$msg}
</div>
{/if}

<div align="center" class="centermain">
  <div class="main">
    <table class="adminheading">
    <tr>
      <th class="catedras">
        Catedras: 
      </th>
      <th width="350">
      	<table width="350">
      	<form id="adminForm" action="{$smarty.server.SCRIPT_NAME}?com=catedras" method="post" name="adminForm">
    		<tr>
    			<td>Nombre: <input name="catedra" type = "text" id="catedra" value="{$catedra}"></td>
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
      <th class="title">ID</th>
       <th class="title">Catedra</th>
      <th class="title">Programa</th>
      <th class="title">Semestre</th>
      <th class="title">Horas</th>
      <th class="title">Acciones</th>
    </tr>
   {section name=row loop=$data}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
       onmouseout="rowOutEffect(this)">
      <td onclick="document.location.href='?com=catedras&do=view&cid={$data[row].id}'">{$smarty.section.row.iteration}</td>
      <td onclick="document.location.href='?com=catedras&do=view&cid={$data[row].id}'">{$data[row].id}</td>
      <td onclick="document.location.href='?com=catedras&do=view&cid={$data[row].id}'">{$data[row].nombre}</td>
      <td onclick="document.location.href='?com=catedras&do=view&cid={$data[row].id}'">{$data[row].programa} ({$data[row].descripcion})</td>
      <td onclick="document.location.href='?com=catedras&do=view&cid={$data[row].id}'">{$data[row].semestre}</td>
      <td onclick="document.location.href='?com=catedras&do=view&cid={$data[row].id}'">{$data[row].horas}</td>
      <td><a href="index2.php?com=catedras&do=view&cid={$data[row].id}">Editar</td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="7">No se han registrado catedras</td>
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

