<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link href="css/basicstyles.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="css/styles.css" type="text/css" />
  <link rel="stylesheet" href="css/template.css" type="text/css" />
  <link rel="stylesheet" href="css/tabpane.css" type="text/css" />
  <link rel="stylesheet" href="css/general.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/tiny_mce/tiny_mce_popup.js"></script>
<script type="text/javascript" src="js/tiny_mce/plugins/jfilebrowser/js/dialog.js"></script>
{literal}
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function() {
    	$("#adminForm").validate({ 
			rules: {
				urlfoto: { /*id del campo que se aplica la regla*/
				accept: "jpg|png|gif" /*extensiones aceptadas*/
				}
			}
		});
	});

	</script>
{/literal}
</head>
<body>
<div id="media_upload">
	<form name="adminForm" id="adminForm" method="post" enctype="multipart/form-data" action="filebrowser.php?action=upload">
		<table width="100%">
			<tr>
				<td>
					Archivo: <input type="file" size="20" maxlength="120" name="imagen" id="imagen" value="" class="required accept" />
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<input name="cargar" type="submit" id="cargar" value="Subir" >
				</td>
			</tr>
		</table>
	</form>
</div>
<div id="media_box">
{section name=row loop=$media}
	<div id='image_box' onclick="jFileBrowserDialog.insert('{$path_img}{$media[row].imagen}', 
			'1', '{$media[row].imagen}');return false;">
	<img src='{$media[row].path}/{$media[row].imagen}' 
		width="80" height="60"	name="{$media[row].imagen}" 
		onClick="cambiar('{$media[row].imagen}')">
	<div id='img_name'>{$media[row].imagen}</div>
		<a href="filebrowser.php?action=drop&img={$media[row].imagen}" 
		><img src="images/remove.png"/></a>					</div>
{sectionelse}
	No hay imágenes
{/section}
</div>
</body>