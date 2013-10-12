<html>
<head>
  <title>{$title}</title>
  <link rel="stylesheet" href="css/login_styles.css" type="text/css" />
  <link rel="stylesheet" href="css/styles.css" type="text/css" />
  {literal}
  <script language="javascript" type="text/javascript">
  function setFocus() {
      document.loginForm.handle.select();
      document.loginForm.handle.focus();
  }

  function submitbutton(pressbutton) {
      var form = document.loginForm;

      // do field validation
      if (form.handle.value == "") {
          alert( "Debe ingresar el Nombre de Usuario" );
      } else if (form.passwd.value == "") {
          alert( "Debe ingresar el Password" );
      } else {
          submitform( pressbutton );
      }
  }
  </script>
  {/literal}
</head>
<body onload="setFocus();">
