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
      <th class="evaluacion">
        Asignaturas en curso: 
      </th>
      <th width="350"></th>
    </tr>
    </table>
    <table class="adminlist">
    <tr>
      <th class="title">#</th>
      <th class="title">ID</th>
      <th class="title">Curso - Tutor</th>
      <th class="title">Acciones</th>
    </tr>
   {section name=row loop=$data}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
       onmouseout="rowOutEffect(this)">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$data[row].id}</td>
      <td>{$data[row].curso}</td>
      <td>
          
          {if $data[row].evaluado eq '1'}
           evaluado
          {else}
            <a href="index2.php?com=evaluacion&do=set&cid={$data[row].id}">
               <img src="images/iconos/checkedbox.png" alt="Evaluar">
            </a>
          {/if}
      </td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="7">No se han registrado cursos</td>
    </tr>
    {/section}
    </table>
  </div>
<div id="break"></div>
</div>

