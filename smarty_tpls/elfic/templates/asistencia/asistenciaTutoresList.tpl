<br />
{if $msg neq ''}
<div class="message">
  {$msg}
</div>
{/if}
{literal}
    <script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$("#searchform").validate();
		});
	</script>
{/literal}
{literal}
<script language="javascript" type="text/javascript">


    // This function gets called when the end-user clicks on some date.
    function selected(cal, date) {
	cal.sel.value = date; // just update the date in the input field.
	if (cal.dateClicked && cal.sel.id == "nonexistent")
	// if we add this call we close the calendar on single-click.
	// just to exemplify both cases, we are using this only for the 1st
	// and the 3rd field, while 2nd and 4th will still require double-click.
	cal.callCloseHandler();
    }

    // And this gets called when the end-user clicks on the _selected_ date,
    // or clicks on the "Close" button.  It just hides the calendar without
    // destroying it.
    function closeHandler(cal) {
	cal.hide();                        // hide the calendar
	//  cal.destroy();
	_dynarch_popupCalendar = null;
    }

    // This function shows the calendar under the element having the given id.
    // It takes care of catching "mousedown" signals on document and hiding the
    // calendar if the click was outside.
    function showCalendar(id, format, showsTime, showsOtherMonths) {
	var el = document.getElementById(id);
	if (_dynarch_popupCalendar != null) {
	    // we already have some calendar created
	    _dynarch_popupCalendar.hide();                 // so we hide it first.
	} else {
	    // first-time call, create the calendar.
	    var cal = new Calendar(1, null, selected, closeHandler);
	    // uncomment the following line to hide the week numbers
	    // cal.weekNumbers = false;
	    if (typeof showsTime == "string") {
		cal.showsTime = true;
		cal.time24 = (showsTime == "24");
	    }
	    if (showsOtherMonths) {
		cal.showsOtherMonths = true;
	    }
	    _dynarch_popupCalendar = cal;                  // remember it in the global var
	    cal.setRange(1900, 2070);        // min/max year allowed.
	    cal.create();
	}
	_dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
	_dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
	_dynarch_popupCalendar.sel = el;                 // inform it what input field we use

	// the reference element that we pass to showAtElement is the button that
	// triggers the calendar.  In this example we align the calendar bottom-right
	// to the button.
	_dynarch_popupCalendar.showAtElement(el, "Br");        // show the calendar

	return false;
    }
    </script>
    {/literal}
<div align="center" class="centermain">
  <div class="main">
    <table class="adminheading">
    <tr>
      <th class="asistencia-tut">
        Control de Asistencia Tutores
      </th>
      <th width="600">
          <table width="600" >
      	    <tr>
      	        <td>
      	            <form id="searchform" action="index2.php?com=asistencia" method="post">
			        <div id = "searchcontainer">
			          <div id="searchfield">Tutor: 
				        <select name="tutor" id="tutor" onChange="getCursosTutor();">
				           <option value="">--</option>
				           {html_options options=$tutores selected=$sel_tutor}
				        </select>
				        </div>
				        <div id="searchfield">
				        <div id="cursoscombo">
				        Curso: 
				        <select name="catedra" id="catedra" >
				           <option value="">--</option>
				           {html_options options=$cursos selected=$sel_curso}
				        </select>
				        </div>
				     </div>
				     <div id="searchfield">
				     Fecha Inicial: <input name="fini" type="text" id="fini" size="10" maxlength="10"/>
					<input type="reset" value="..." onClick="return showCalendar('fini', '%Y-%m-%d', '24', true);" />
					Fecha Final: <input name="ffin" type="text" id="ffin" size="10" maxlength="10" />
					<input type="reset" value="..." onClick="return showCalendar('ffin', '%Y-%m-%d', '24', true);" />
					
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
      <th class="title">Tutor</th>
      <th class="title">Entrada</th>
      <th class="title">Salida</th>
      <th class="title">Curso</th>
      <th class="title">Comentarios</th>
    </tr>
   {section name=row loop=$lista}
   <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}">
      <td>{$smarty.section.row.iteration}</td>
      <td>{$lista[row].id}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >{$lista[row].tutor}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >{$lista[row].entrada}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >{$lista[row].salida}</td>
      <td onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >{$lista[row].catedra} ({$lista[row].grupo}) - {$lista[row].dia}</td>
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