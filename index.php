<!DOCTYPE html>
<html lang="en">
  <head>

<!--
   _____          _ _     _            _
  / ____|        | (_)   | |          | |
 | |     __ _  __| |_  __| |_   _  ___| |__   ___
 | |    / _` |/ _` | |/ _` | | | |/ __| '_ \ / _ \
 | |___| (_| | (_| | | (_| | |_| | (__| | | | (_) |
  \_____\__,_|\__,_|_|\__,_|\__,_|\___|_| |_|\___/
-->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Generador automático de contraseñas online">
    <meta name="author" content="Cadiducho">
    <link rel="icon" type="image/png" href="../icon.png" />

    <title>Generador de Contrase&ntilde;as | Cadiducho.com </title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Css de la esta pagina -->
    <link href="pass.css" rel="stylesheet">
	<link href="nuevo.css" rel="stylesheet">

  </head>

  <body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand"><a href="https://Cadiducho.com">Cadiducho.com</a></h3>
                        <ul class="nav masthead-nav">
                            <li class="active"><a href="">Pass</a></li>
                            <li><a href="https://Cadiducho.com">Inicio</a></li>
                        </ul>
                    </div>
                </div>
                <div class="inner cover">
                    <h1 class="cover-heading morado"><i class="fa fa-lock"></i> Caracter&iacute;sticas de tu contrase&ntilde;a: </h1>

<?
/* Código del programa */
// TODO: Mover a clase aparte
$limit = 100; //Si no me tirais la web locos

function generate_pass() {
	global $limit;

	$pass = '';
	$length = '';
	$nums = array();
	$caps = array();
	$lowers = array();
	$symbols = array();

	if ($_REQUEST['usenums'] ?? '')
		$nums = range('0', '9');

	if ($_REQUEST['usecaps'] ?? '')
		$caps = range('A', 'Z');

	if ($_REQUEST['uselower'] ?? '')
		$lowers = range('a', 'z');

	if ($_REQUEST['usesymbols'] ?? '')
		$symbols =  array_merge(range("{", "~"), range(":", "@"));

	$chars = array();

	if (!empty($nums)) {
		foreach ($nums as $value)
			$chars[] = $value;
	}

	if (!empty($caps)) {
		foreach ($caps as $value)
			$chars[] = $value;
	}

	if (!empty($lowers)) {
		foreach ($lowers as $value)
			$chars[] = $value;
	}

	if (!empty($symbols)) {
		foreach ($symbols as $value)
			$chars[] = $value;
	}

	if (empty($chars))
		$chars = array_merge(array_merge(range('a', 'z'), range('A', 'Z')), range('0', '9'));

	$count = count($chars);

	if ((!empty($_REQUEST['value']) && is_numeric($_REQUEST['value']) && (abs($_REQUEST['value']) < $limit)) )
		$length = abs((int) $_REQUEST['value']);
	elseif (($_REQUEST['value'] ?? '') != '0')
		$length = 'keepalive';
	else
		show_error();

	mt_srand((double)microtime() * 1000000);

	if ($length != 'keepalive') {
		for($i = 0; $i < $length; $i++)
			$pass .= $chars[mt_rand(0, $count - 1)];
	}
	if (!empty($pass))
		echo '<i class="fa fa-check verde"></i> Tu contraseña generada es:<br /><tt><strong>' . $pass . '</strong></tt>';
}


function show_error() {
	global $limit;

	if ($limit <= abs($_REQUEST['value']))
		$error = "Contraseña mayor o igual que $limit caracteres.";
	elseif( !is_numeric($_REQUEST['value']) && (!in_array($_REQUEST['value'], array('', '0', 'keepalive'))) )
		$error = "No has incluido un valor numerico para el n&uacute;mero de caracteres.";
	elseif ($_REQUEST['value'] == '0')
		$error = "El número de caracteres es 0.";
	elseif (empty($_REQUEST['value']))
		$error = "El número de caracteres esta vacio.";
	else
		$error = "Ocurrio un error procesando la informacion.";
	/* Escribe el error */
	echo "<i class='fa fa-times rojo'></i> Se han producido ciertos errores: <br /><tt><strong>$error</strong></tt>";
	return;
}


    $keepalive = !isset($_REQUEST['value']);

    ?>

            <form action="<?=$_SERVER['SCRIPT_NAME']?>" method="post">
                <fieldset>
                    <small>Rellena el formulario y pulsa en generar contraseña</small>

                    <fieldset class="form-group">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="usenums" <?=($_REQUEST['usenums'] ?? false && !$keepalive) ? 'checked="checked"' : ''?> >
                        ¿Incluir números?
                      </label>
                    </div>
                    <div class="form-checks">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="usecaps" <?=($_REQUEST['usecaps'] ?? false && !$keepalive) ? 'checked="checked"' : ''?> >
                        ¿Incluir mayúsculas?
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="uselower" <?=($_REQUEST['uselower'] ?? false && !$keepalive) ? 'checked="checked"' : ''?> >
                        ¿Incluir minúsculas?
                      </label>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="usesymbols" <?=($_REQUEST['usesymbols'] ?? false && !$keepalive) ? 'checked="checked"' : ''?>>
                        ¿Incluir símbolos o caracteres especiales?
                      </label>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-4 col-xs-offset-4">
                            <label class="col-form-label col-form-label-sm" for="numCaracteres">Número de caracteres</label>
                            <input class="form-control form-control-sm" type="number" min="1" max="20" id="numCaracteres" name="value" value="<?=($_REQUEST['value'] ?? 8)?>">
                        </div>
                    </div>
                  </fieldset>
                  <input value="Generar" class="btn btn-lg btn-info " type="submit" />
                </fieldset>
            </form>

    <?php
		generate_pass();


?>
                </div>
                <div class="fiar">
                    <br />
                    <p>Ninguna contraseña es guardada. ¡Compruébalo en <a href="https://github.com/Cadiducho/PasswordGenerator" class="verde">GitHub!</a>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>&copy; 2014 - <?= date('Y'); ?>, Desarrollado por <a href="https://twitter.com/Cadiducho"> @Cadiducho</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
