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
    	{if $asistencia eq 1}
        <div style="float:left;">
            <div class="icon">
                <a href="index2.php?com=asistencia">
                    <img src="images/iconos/asistencia_tut.png"  alt="Asistencia" align="middle" border="0" />  
                    <span>Asistencia Tutores</span>
                </a>
            </div>
        </div>
        {/if}
        {if $asistencia eq 1}
        <div style="float:left;">
            <div class="icon">
                <a href="index2.php?com=asistencia&do=list_fun">
                    <img src="images/iconos/xclock.png"  alt="Asistencia" align="middle" border="0" />  
                    <span>Asistencia Funcionarios</span>
                </a>
            </div>
        </div>
       {/if}
        {if $cursos eq 1}
       <div style="float:left;">
            <div class="icon">
                <a href="index2.php?com=cursos">
                    <img src="images/iconos/cursos.png"  alt="Cursos" align="middle" border="0" />  
                    <span>Cursos</span>
                </a>
            </div>
        </div>
        {/if}
         {if $catedras eq 1}
       <div style="float:left;">
            <div class="icon">
                <a href="index2.php?com=catedras">
                    <img src="images/iconos/catedras.png"  alt="Catedras" align="middle" border="0" />  
                    <span>Catedras</span>
                </a>
            </div>
        </div>
        {/if}
        {if $evaluacion eq 1}
       <!-- <div style="float:left;">
            <div class="icon">
                <a href="index2.php?com=evaluacion">
                    <img src="images/iconos/evaluacion.png"  alt="Encuestas" align="middle" border="0" />  
                    <span>Evaluación Tutores</span>
                </a>
            </div>
        </div> -->
        {/if}
        {if $reportes eq 1}
        <div style="float:left;">
            <div class="icon">
                <a href="index2.php?com=reportes">
                    <img src="images/iconos/reportes.png"  alt="Reportes" align="middle" border="0" />  
                    <span>Reportes</span>
                </a>
            </div>
        </div>
        {/if}
        {if $usuarios eq 1}
        <div style="float:left;">
            <div class="icon">
                <a href="index2.php?com=usuarios">
                    <img src="images/iconos/user.png"  alt="Usuarios" align="middle" border="0" />  
                    <span>Usuarios</span>
                </a>
            </div>
        </div>
        {/if}
</div>
<td width="10%">&nbsp;</td>

      <td width="45%" valign="top">
	<div style="width: 100%;">
	  <form action="index2.php" method="post" name="adminForm">
	  <div class="tab-page" id="modules-cpanel">
	  
	  <script type="text/javascript">
	    var tabPane1 = new WebFXTabPane( document.getElementById( "modules-cpanel" ), 1 )
	  </script>
	  
	    <div class="tab-page" id="module1">
	      <h2 class="tab">Inicio</h2>
	      <script type="text/javascript">
	        tabPane1.addTabPage( document.getElementById( "module1" ) );
	      </script>

	      <table class="adminlist">
	      <tr>
	        <th>!Hola {$usuario}!</th>
	      </tr>
	       <tr>
	       <td>
	           Bienvenido a eAcademyControl, sistema de gestión y control de asistencia. Dependiendo de tu rol, aquí puedes realizar diferentes tareas:
	           <ul>
	            <li>Consultas de registros de asistencia de Tutores y Funcionarios (Coordinadores)</li>
	            <li>Gestión de cursos y agendas (Coordinadores - Tutores)</li>
	           </ul>
	       <td>
	       </tr>
	       </tr>
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
