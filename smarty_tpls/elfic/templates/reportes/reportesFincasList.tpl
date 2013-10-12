<div align="center" class="centermain">
  <div class="main">
    <table class="adminheading">
    <tr>
      <th>
        Listado General de Fincas - Total de Predios {$total_fincas} 
      </th>
      <th>
        <a href="index2.php?com=reportes&do=listtoexcel">
        	<img src="images/iconos/icono-excel.jpg" border="0">
        </a>
      </th>
    </tr>
    </table>
    <table class="adminlist">
    <tr>
      <th class="title">#</th>
      <th class="title">Nombre</th>
      <th class="title">Hectareas / Metros</th>
      <th class="title">Municipio</th>
      <th class="title">Departamento</th>
      <th class="title">Productos</th>
    </tr>
   {section name=row loop=$fincas}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='?com=fincas&do=view&fid={$fincas[row].id}'">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$fincas[row].nombre}</td>
      <td>{$fincas[row].hectareas} Has. - {$fincas[row].metros} mts.</td>
      <td>{$fincas[row].municipio}</td>
      <td>{$fincas[row].departamento}</td>
     <td>{$fincas[row].productos}</td>
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

