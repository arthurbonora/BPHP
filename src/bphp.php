<?php
/* =====================================================================
   BPHP 4 - Biblioteca PHP
   Site oficial: https://github.com/arthurbonora/BPHP/
========================================================================*/
require 'config.php';
$connection = new mysqli($host, $usuario, $senha, $banco);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
define('CONN', $connection);
function Bdebug($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}
function Bdelete($table, $conditions) {
    $conditionList = [];
    foreach ($conditions as $column => $value) {
        $conditionList[] = "$column = ?";
    }
    $conditionClause = implode(" AND ", $conditionList);
    $query = "DELETE FROM $table WHERE $conditionClause";
    $stmt = CONN->prepare($query);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param(str_repeat('s', count($conditions)), ...array_values($conditions));
    return $stmt->execute();
}

function Binsert($table, $data) {
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), '?'));
    $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = CONN->prepare($query);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param(str_repeat('s', count($data)), ...array_values($data));
    return $stmt->execute();
}

function Bselect($table, $conditions = [], $columns = ['*']) {
    $columnsList = implode(", ", $columns);
    $query = "SELECT $columnsList FROM $table";
    if (!empty($conditions)) {
        $conditionList = [];
        foreach ($conditions as $column => $value) {
            $conditionList[] = "$column = ?";
        }
        $query .= " WHERE " . implode(" AND ", $conditionList);
    }
    $stmt = CONN->prepare($query);
    if ($stmt === false) {
        return false;
    }
    if (!empty($conditions)) {
        $stmt->bind_param(str_repeat('s', count($conditions)), ...array_values($conditions));
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
function Bupdate($table, $data, $conditions) {
    $setList = [];
    foreach ($data as $column => $value) {
        $setList[] = "$column = ?";
    }
    $setClause = implode(", ", $setList);
    $conditionList = [];
    foreach ($conditions as $column => $value) {
        $conditionList[] = "$column = ?";
    }
    $conditionClause = implode(" AND ", $conditionList);
    $query = "UPDATE $table SET $setClause WHERE $conditionClause";
    $stmt = CONN->prepare($query);
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param(str_repeat('s', count($data) + count($conditions)), ...array_merge(array_values($data), array_values($conditions)));
    return $stmt->execute();
}
//herdadas v3
function Balerta ($msg) {
	?> <script language="javascript"> alert ('<? echo "$msg"; ?>') </script> <?
}
function Bconfirm ($msg) {
	?>
    <script language="javascript"> confirm ('<? echo "$msg"; ?>') </script>
	<?php
}
function Bcontdiasuteis($timestampInicial, $timestampFinal = null, $feriados = []) {
    if (!isset($timestampInicial)) return false;
	if (!isset($timestampFinal)) $timestampFinal = time();
    $dias = abs(($timestampFinal - $timestampInicial) / 86400);
    $uteis = 0;
    for ($i = 0; $i <= $dias; $i++) {
        $diaAtual = $timestampInicial + ($i * 86400);
        $diaSemana = date('w', $diaAtual);
        if ($diaSemana != 0 && $diaSemana != 6 && !in_array($diaAtual, $feriados)) {
            $uteis++;
        }
    }
    return $uteis;
}
function Bdatabr2datamysql($databr) {
	$array = explode ('/',$databr);
	$datamysql = $array[2]."-".$array[1]."-".$array[0];
	return $datamysql;
}
function Beditor() {
 	?>
	<script type="text/javascript" src="bphp/editor/tinymce.min.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			selector: "textarea#beditor",
			theme: "modern",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			toolbar2: "print preview media | forecolor backcolor emoticons",
			image_advtab: true,
			templates: [
				{title: 'Test template 1', content: 'Test 1'},
				{title: 'Test template 2', content: 'Test 2'}
			]
		});
	</script>
	<?php
}
function Bgeracodbarras ($string) {
?>
    <script type="text/javascript" src="bytescoutbarcode128_1.00.07.js"></script>
    <img id="barcodeImage" style="border:0px;"/>
	</p>
    <script type="text/javascript">
   	function updateBarcode() {
		var barcode = new bytescoutbarcode128();
		var value = <?php echo $string; ?>;
   		barcode.valueSet(value);
   		barcode.setMargins(5, 5, 5, 5);
   		barcode.setBarWidth(2);
   		var width = barcode.getMinWidth();
   		barcode.setSize(width, 100);
   		var barcodeImage = document.getElementById('barcodeImage');
   		barcodeImage.src = barcode.exportToBase64(width, 100, 0);
   	}
    </script>
<?php
}
function Bhash($string) {
	$hash___ = sha1($string);
	$hash__  = sha1($hash___);
	$hash_	 = md5($hash__);
	return $hash_;
}
function Blinkvoltar() {
	$_SESSION['Blinkvoltar3'] = $_SESSION['Blinkvoltar2'];
	$_SESSION['Blinkvoltar2'] = $_SESSION['Blinkvoltar'];
	$_SESSION['Blinkvoltar'] = $_SESSION['Blinkatual'];
	$hist_server = $_SERVER['SERVER_NAME'];
	$hist_endereco = $_SERVER ['REQUEST_URI'];
	$_SESSION['Blinkatual'] =  "http://" . $hist_server . $hist_endereco;
}
function Bmostraerros () {
	ini_set("display_errors",1);
	ini_set("display_startup_erros",1);
	error_reporting(E_ALL);
}
function Bpeganumeros($str) {
        return preg_replace("/[^0-9]/", "", $str);
}
function Brand ($item1,$item2,$item3,$item4,$item5) {
	$array = array($item1, $item2, $item3, $item4, $item5);
	return $array[rand(0, 5)];
}
function Bredirecionamentojs($link){
	if ($link==-1){
		echo" <script>history.go(-1);</script>";
	}else{
		echo" <script>document.location.href='$link'</script>";
	}
}
function Bseg ($string) {
	$caracteres = array(";","\\","''","``","'");
	$string_seg = str_replace ($caracteres, "B", $string);
	return $string_seg;
}
function Bsetpreco ($valor) {
	$retur_preco = str_replace(',','.', $valor);
	return $retur_preco;
}
function Btoken() {
	$rand1 = rand (0,100);
	$rand2 = rand (0,100);
	$rand3 = rand (0,100);
	$rand4 = rand (0,100);
	$rand5 = rand (0,100);
	$rand6 = rand (0,100);
	$rand7 = rand (0,100);
	$rand8 = rand (0,100);
	$rand9 = rand (0,100);
	$rand10 = rand (0,100);
	$token = "btoken".$rand1.$rand2.$rand3.$rand4.$rand5.$rand6.$rand7.$rand8.$rand9.$rand10;
	return $token;
}
function Bvalidacnpj($cnpj) {
	$cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    if (strlen($cnpj) != 14) {
        return false;
    }
    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }
    $calcularDigito = function($base) {
        $tamanho = strlen($base);
        $soma = 0;
        $pos = $tamanho - 7;
        for ($i = $tamanho; $i >= 1; $i--) {
            $soma += $base[$tamanho - $i] * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
        $resultado = $soma % 11;
        return ($resultado < 2) ? 0 : 11 - $resultado;
    };
    $base = substr($cnpj, 0, 12);
    $digito1 = $calcularDigito($base);
    $digito2 = $calcularDigito($base . $digito1);
    return $cnpj[12] == $digito1 && $cnpj[13] == $digito2;
}
function Bvalidacpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11) {
        return false;
    }
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    $calcularDigito = function($base) {
        $tamanho = strlen($base);
        $soma = 0;
        for ($i = 0; $i < $tamanho; $i++) {
            $soma += $base[$i] * (($tamanho + 1) - $i);
        }
        $resto = $soma % 11;
        return ($resto < 2) ? 0 : 11 - $resto;
    };
    $digito1 = $calcularDigito(substr($cpf, 0, 9));
    $digito2 = $calcularDigito(substr($cpf, 0, 9) . $digito1);
    return $cpf[9] == $digito1 && $cpf[10] == $digito2;
}
function Bverificaurl($link) {
    if (!filter_var($link, FILTER_VALIDATE_URL)) {
        return false;
    }
    $ch = curl_init($link);
    curl_setopt($ch, CURLOPT_NOBODY, true); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        curl_close($ch);
        return false;
    }
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $http_code == 200;
}