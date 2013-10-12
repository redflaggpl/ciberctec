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
        Evaluación de Tutores: 
      </th>
      <th width="500">
          <table width="600" >
      	    <tr>
      	        <td>
      	            <form id="searchform" action="index2.php?com=evaluacion" method="post">
			        <div id = "searchcontainer">
			          <div id="searchfield">Tutor: 
				        <input type="text" name="tutor" id="tutor" value={$tutor}>
				        </div>
				        <div id="searchfield">
					        Curso: 
					         <input type="text" name="curso" id="curso" value={$curso}>
				        </div>
				        <div id="searchfield">
				        	<input type="submit" label="Filtrar" value="filtrar">
				        </div>
			        </div>
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
      <th class="title">Estudiante</th>
      <th class="title">Tutor</th>
      <th class="title">Curso</th>
      <th class="title">Concepto</th>
    </tr>
   {section name=row loop=$data}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}" onmouseover="rowOverEffect(this)" 
       onmouseout="rowOutEffect(this)" onclick="document.location.href='?com=evaluacion&do=getEval&eid={$data[row].id}'">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$data[row].id}</td>
      <td>{$data[row].estudiante}</td>
      <td>{$data[row].tutor}</td>
      <td>{$data[row].curso}</td>
      <td>{$data[row].concepto}</td>
    </tr>
    {sectionelse}
    <tr>
      <td colspan="7">No se han registrado evaluaciones</td>
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

