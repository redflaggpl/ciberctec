{assign var="title" value="ORBIOTEC :: CRM :: Panel de Control"}
{include file="html_top.tpl"}
{include file="html_header.tpl"}
{include file="top_menu.tpl"}
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
      <th class="cpanel">
        Panel de Control
      </th>
    </tr>
    </table>
    <table class="adminform">
    <tr>
      <td width="45%" valign="top">
	<div id="cpanel">
	  <div style="float:left">
	    <div class="icon">
	      <a href="{$smarty.server.SCRIPT_NAME}?action=process&task=new"><img
	        src="images/proc_new.png" align="middle" border="0" />
	        <span>Adicionar Nuevo Proceso</span>
	      </a>
	    </div>
	  </div>
	  <div style="float:left">
	    <div class="icon">
	      <a href="{$smarty.server.SCRIPT_NAME}?action=process&task=list"><img
	        src="images/proc_mng.png" align="middle" border="0" />
	        <span>Manejador de Procesos</span>
	      </a>
	    </div>
	  </div>
	  <div style="float:left">
            <div class="icon">
              <a href="{$smarty.server.SCRIPT_NAME}?action=users&task=list"><img
                src="images/users_mng.png" align="middle" border="0" />
                <span>Manejador de Usuarios</span>
              </a>
            </div>
          </div>
	  <div style="float:left">
            <div class="icon">
              <a href="{$smarty.server.SCRIPT_NAME}?action=monitor&task=list"><img
                src="images/monitor_mng.png" align="middle" border="0" />
                <span>Monitor de Acciones</span>
              </a>
            </div>
          </div>
	  <div style="float:left">
            <div class="icon">
              <a href="{$smarty.server.SCRIPT_NAME}?action=archive&task=list"><img
                src="images/archive_mng.png" align="middle" border="0" />
                <span>Manejador del Archivo</span>
              </a>
            </div>
          </div>
	  <div style="float:left">
            <div class="icon">
              <a href="{$smarty.server.SCRIPT_NAME}?action=trash&task=list"><img
                src="images/trash_mng.png" align="middle" border="0" />
                <span>Manejador de Papelera</span>
              </a>
            </div>
          </div>
	  <div style="float:left">
            <div class="icon">
              <a href="{$smarty.server.SCRIPT_NAME}?action=setup&task=edit"><img
                src="images/setup_mng.png" align="middle" border="0" />
                <span>Configuraci&oacute;n Global</span>
              </a>
            </div>
          </div>
	  <div style="float:left">
            <div class="icon">
              <a href="{$smarty.server.SCRIPT_NAME}?action=billonline"><img
                src="images/csvbill_mng.png" align="middle" border="0" />
                <span>CSV Factura</span>
              </a>
            </div>
          </div>
	</div>
      </td>
      <td width="10%">&nbsp;</td>
      <td width="45%" valign="top">
	<div style="width: 100%;">
	  <form action="index2.php" method="post" name="adminForm">
	  <div class="tab-page" id="modules-cpanel">
	  {literal}
	  <script type="text/javascript">
	    var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
	  </script>
	  {/literal}
	    <div class="tab-page" id="module1">
	      <h2 class="tab">Preguntas</h2>
	      <script type="text/javascript">
	        tabPane1.addTabPage( document.getElementById( "module1" ) );
	      </script>
	      <table class="adminlist">
	      <tr>
	        <th colspan="4">M&aacute;s Recientes Sin Respuesta</th>
	      </tr>
	      {section name=row loop=$naqs}
	      <tr bgcolor="{cycle values="#f4f4f4,#e8e8e8"}">
		<td width="70" valign="top" nowrap>{$naqs[row].pq_question_date}</td>
		<td valign="top">
		  [ <i>{$naqs[row].name}</i> ] &nbsp; <a title="Editar Pregunta"
		  href="{$smarty.server.SCRIPT_NAME}?action=process&task=qedit&qid={$naqs[row].pq_id}&id={$naqs[row].pd_id}">{$naqs[row].pq_question}</a></td>
	      </tr>
	      {/section}
	      </table>
	    </div>
	  </div>
	  </form>
	</div>
      </td>
    </tr>
    </table>
  </div>
</div>
<div id="break"></div>
</div>
{include file="html_footer.tpl"}
{include file="html_bottom.tpl"}

