<div id="modulo">
    <form action="index2.php?com={$link}" method="post">
    <table width="300" class="adminlist">
    	<tr>
    	    <th>{$nombre}</th>
    	</tr>
    	<tr>
    		<td>Cursos: 
    		    <select name="curso_id">
    		        <option value="">-Curso-</option>
				   {html_options options=$data }
				</select>
				<input type="submit" value="Registrar" id="submit" name="submit">
				<input type="hidden" value="setInTutor" name="do" id="do">
    		</td>
        </tr>
    </table>
    </form>
</div>