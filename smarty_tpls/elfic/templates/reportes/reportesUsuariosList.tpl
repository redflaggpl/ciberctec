<div align="center" class="centermain">
  <div class="main">
    <table class="adminheading">
    <tr>
      <th>
        Listado General de Usuarios - Total de Usuarios {$total} 
      </th>
      <th>
        <a href="index2.php?com=reportes&do=usuariostoexcel">
        	<img src="images/iconos/icono-excel.jpg" border="0">
        </a>
      </th>
    </tr>
    </table>
    <table class="adminlist">
    <tr>
      <th class="title">#</th>
      <th class="title">Nombre</th>
      <th class="title">Usuario</th>
      <th class="title">Perfil</th>
      <th class="title">Municipio</th>
      <th class="title">Departamento</th>
      <th class="title">Productos</th>
      <th class="title">Registro</th>
    </tr>
   {section name=row loop=$u}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" 
       onmouseover="rowOverEffect(this)" 
       onmouseout="rowOutEffect(this)" 
       onclick="document.location.href='?com=usuarios&do=view&uid={$u[row].id}'">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$u[row].name}</td>
      <td>{$u[row].username}</td>
      <td>{$u[row].perfil}</td>
      <td>{$u[row].municipio}</td>
      <td>{$u[row].departamento}</td>
      <td>{$u[row].productos}</td>
      <td>{$u[row].registerDate}</td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="8">No hay registros</td>
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

