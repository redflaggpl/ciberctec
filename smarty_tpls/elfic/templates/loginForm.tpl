{assign var="title" value=""}
{include file="html_login_top.tpl"}
{include file="header.tpl"}
<div id="ctr" align="center">
{if $msg}
<div class="message">
  {$msg}
</div>
{/if}
<div class="login">
    <div class="login-form">
	<img src="images/login_text.png" alt="Login" />
	<form action="{$smarty.server.SCRIPT_NAME}?action=submit" method="post">
	{if $error ne ""}
            {if $error eq "name_empty"}You must supply a name.
            {elseif $error eq "comment_empty"} You must supply a comment.
            {/if}
	{/if}
	<div class="form-block">
	    <div class="inputlabel">Usuario:</div>
	    <div><input type="text" name="login" class="inputbox" value="{$post.login|escape}" size="40" /></div>
	    <div class="inputlabel">Password:</div>
	    <div><input type="password" name="passwd" class="inputbox" value="{$post.passwd|escape}" size="40" /></div>
	    <div align="left"><input type="submit" class="button" value="Iniciar Sesi&oacute;n" /></div>
	</div>
        </form>
    </div>
    <div class="login-text">
	<div class="ctr"><img src="images/app_login.png" width="64" height="64" alt="security" /></div>
	<p>Hola!</p>
	<p>Por favor, ingrese con un <i>nombre de usuario</i> y <i>contrase&ntilde;a</i> v&aacute;lidos.</p>
    </div>
    <div class="clr"></div>
</div>
</div>
<div id="break"></div>
</div>
{include file="footer.tpl"}
{include file="html_bottom.tpl"}

