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
      <th class="cursos">
        Cursos: 
      </th>
      <th width="350">
      	<table width="350">
      	<form id="adminForm" action="{$smarty.server.SCRIPT_NAME}?com=cursos" method="post" name="adminForm">
    		<tr>
    			<td>Nombre: <input name="curso" type = "text" id="curso" value="{$curso}"></td>
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
      <th class="title">Programa</th>
      <th class="title">Curso</th>
      <th class="title">Grupo</th>
      <th class="title">Periodo</th>
      <th class="title">Tutor</th>
      <th class="title">Agenda</th>
      <th class="title">Dia/Hora</th>
      <th class="title">Acciones</th>
    </tr>
   {section name=row loop=$data}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
       onmouseout="rowOutEffect(this)">
      <td onclick="document.location.href='?com=cursos&do=view&cid={$data[row].id}'">{$smarty.section.row.iteration}</td>
      <td onclick="document.location.href='?com=cursos&do=view&cid={$data[row].id}'">{$data[row].id}</td>
      <td onclick="document.location.href='?com=cursos&do=view&cid={$data[row].id}'">{$data[row].programa}</td>
      <td onclick="document.location.href='?com=cursos&do=view&cid={$data[row].id}'">{$data[row].curso}</td>
      <td onclick="document.location.href='?com=cursos&do=view&cid={$data[row].id}'">{$data[row].grupo}</td>
      <td>{$data[row].periodo}</td>
      <td>{$data[row].tutor}</td>
      <td>
          {if $data[row].agenda eq 0}
          <a href="index2.php?com=cursos&do=cargarAgenda&cid={$data[row].id}&tutor_id={$data[row].tutor_id}">Cargar</a>
          {else}
           <a href="files/{$data[row].id}.doc" target="_blank">Ver Agenda</a>
          {/if}
      </td>
      <td>{$data[row].dia}/{$data[row].hora}</td>
      <td><a href="index2.php?com=cursos&do=view&cid={$data[row].id}">Editar</td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="7">No se han registrado cursos</td>
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

