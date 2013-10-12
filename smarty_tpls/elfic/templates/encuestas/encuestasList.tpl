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
	<script type="text/javascript">

		function estado(){ 
		    if (document.forms["adminForm1"].chk.checked) 
		     seleccionar_todo();
		    else 
		     deseleccionar_todo();
		} 
	   
        function seleccionar_todo()
		{//Funcion que permite seleccionar todos los checkbox
	
		form = document.forms["adminForm1"]
		for (i=0;i<form.elements.length;i++)
		    {
		    if(form.elements[i].type == "checkbox")form.elements[i].checked=1;
		    }
		} 
	
		function deseleccionar_todo()
		{//Funcion que permite deseleccionar todos los checkbox
	
		form = document.forms["adminForm1"]
		for (i=0;i<form.elements.length;i++)
		    {
		    if(form.elements[i].type == "checkbox")form.elements[i].checked=0;
		    }
		}
	</script>
    
{/literal}
<form id="adminForm1" action="{$smarty.server.SCRIPT_NAME}?com=encuestas" method="post" name="adminForm1">
<div align="center" class="centermain">
  <div class="main">
    <table class="adminheading">
    <tr>
      <th class="questsnew">
        Encuestas 
      </th>
      <th width="350">
          <table width="300" >
      	    <tr>
      	        <td>
      	            <input name="do" type="hidden" id="do" value="delmul"/>
      	            <input name="delmul" type="submit" id="delmul" value="Borrar"/>
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
      <th class="title">
          <input type="checkbox" name="chk" onClick="estado()">
          </th>
      <th class="title">Titulo</th>
      <th class="title">Observaciones</th>
      <th class="title">Fecha de Creación</th>
      <th class="title">Acciones</th>
    </tr>
   {section name=row loop=$lista}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$lista[row].id}</td>
      <td><input type="checkbox" name="cb[{$lista[row].id}]" id="cb[{$lista[row].id}]"></td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='?com=encuestas&do=new&eid={$lista[row].id}'">{$lista[row].titulo}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='?com=encuestas&do=new&eid={$lista[row].id}'">{$lista[row].observaciones}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href='?com=encuestas&do=new&eid={$lista[row].id}'">{$lista[row].fecha}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
          <a href="index2.php?com=encuestas&do=new&eid={$lista[row].id}">Responder</a> - 
          <a href="index2.php?com=encuestas&do=resultados&eid={$lista[row].id}">Resultados</a> - 
          <a href="index2.php?com=encuestas&do=edit&eid={$lista[row].id}">Editar</a>
          <!-- <a href="">Borrar</a>-->
      </td>
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
</form>

