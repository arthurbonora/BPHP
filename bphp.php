<?php
/* =====================================================================
   BPHP 3 - Biblioteca PHP
   Site oficial: sourceforge.net/projects/bphp/
   As coletaneas de codigos terão seus creditos expressamente publicados 
========================================================================*/
function Balerta ($msg) {
	?> <script language="javascript"> alert ('<? echo "$msg"; ?>') </script> <?
}
function Bconfirm ($msg) {
	?>
    <script language="javascript"> confirm ('<? echo "$msg"; ?>') </script>
	<?php 
}
function Bcontdiasuteis($datainicial,$datafinal=null){
	/**
	* Calcula a quantidade de dias úteis entre duas datas (sem contar feriados)
	* @author Marcos Regis
	* @param String $datainicial
	* @param String $datafinal=null
	*/
	if (!isset($datainicial)) return false;
	if (!isset($datafinal)) $datafinal=time();
	$segundos_datainicial = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#","$3/$2/$1",$datainicial));
	$segundos_datafinal = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#","$3/$2/$1",$datafinal));
	$dias = abs(floor(floor(($segundos_datafinal-$segundos_datainicial)/3600)/24 ) );
	$uteis=0;
	for($i=1;$i<=$dias;$i++){
		$diai = $segundos_datainicial+($i*3600*24);
		$w = date('w',$diai);
		if ($w==0){
			//echo date('d/m/Y',$diai)." é Domingo<br />";
		}elseif($w==6){
			//echo date('d/m/Y',$diai)." é Sábado<br />";
		}else{
			//echo date('d/m/Y',$diai)." é dia útil<br />";
			$uteis++;
		}
	}
	return $uteis;
}
function databr2datamysql($databr) {
	$array = explode ('/',$databr);
	$datamysql = $array[2]."-".$array[1]."-".$array[0];
	return $datamysql;
}
function Bdataporextenso () {
		//por Davidson Bruno codigofonte.uol.com.br
		$meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
		$diasdasemana = array (1 => "Segunda-Feira",2 => "Terça-Feira",3 => "Quarta-Feira",4 => "Quinta-Feira",5 => "Sexta-Feira",6 => "Sábado",0 => "Domingo");
		$hoje = getdate();
		$dia = $hoje["mday"];
		$mes = $hoje["mon"];
		$nomemes = $meses[$mes];
		$ano = $hoje["year"];
		$diadasemana = $hoje["wday"];
		$nomediadasemana = $diasdasemana[$diadasemana];
		return "$nomediadasemana, $dia de $nomemes de $ano";
	}
function Beditor () {
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
function Bfavicon ($patchimg) {
	echo "<link href='".$patchimg."' rel='icon' type='image/x-icon' />";
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
function Bheadersmail ($email) {
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	$headers .= "From: ".$email."\r\n"; // remetente
	$headers .= "Return-Path: ".$email."\r\n"; // return-path
	return $headers;
}
function Blinkvoltar() {
	$_SESSION['Blinkvoltar3'] = $_SESSION['Blinkvoltar2'];
	$_SESSION['Blinkvoltar2'] = $_SESSION['Blinkvoltar'];
	$_SESSION['Blinkvoltar'] = $_SESSION['Blinkatual'];
	$hist_server = $_SERVER['SERVER_NAME'];
	$hist_endereco = $_SERVER ['REQUEST_URI'];
	$_SESSION['Blinkatual'] =  "http://" . $hist_server . $hist_endereco;
}
function Blog ($erro, $texto){
	$arq = fopen ('log.log','rw+');
	fwrite ($arq,"[".date("r")."] Info: $erro \n Descrição: $texto \n ---------");
	fclose ($arq);
}
function Bmostraerros () {
	ini_set("display_errors",1);
	ini_set("display_startup_erros",1);
	error_reporting(E_ALL);
}
function Bmodal ($msg) {
	?>	
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
   			<div class="modal-content">
     			<div class="modal-header">
       				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       				<h4 class="modal-title" id="myModalLabel">Alerta</h4>
     			</div>
     			<div class="modal-body">
       				<?php echo $msg; ?>
     			</div>
     			<div class="modal-footer">
       				<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
       			</div>
   			</div>
 		</div>
	</div>
	<script>
		$(document).ready(function() {
   			$('#myModal').modal('show');
		});
	</script>
	<?php
}
function Bpeganumeros($str) {
        return preg_replace("/[^0-9]/", "", $str);
}
function Bpopup ($pagina,$titulo,$comprimento,$largura) { 
	echo("<script language='JavaScript'>
	var width = " . $largura . ";
	var height = " . $comprimento . ";
	var titulo = " . $titulo . ";		
	var left = 50;
	var top = 50;
	URL = '" . $pagina . "';
	window.open(URL, 'titulo', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=no, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
	</script>");     
}
function Brand ($item1,$item2,$item3,$item4,$item5) {
	$array = array('$item1','$item2','$item3','$item4','$item5');       
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
function Bsubmit ($form) {
	echo "<script type='text/javascript'>document.".$form.".submit();</script>";
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
function Bverificaurl( $link ) {        
	$partes_url = @parse_url( $link );
    if (empty( $partes_url["host"])) return( false );
    if (!empty( $partes_url["path"])) {
        $path_documento = $partes_url["path"];
    }
    else {
        $path_documento = "/";
    }
    if (!empty( $partes_url["query"])) {
        $path_documento .= "?" . $partes_url["query"];
    }
    $host = $partes_url["host"];
    $porta = $partes_url["port"];
    // faz um (HTTP-)GET $path_documento em $host";
    if (empty($porta)) $porta = "80";
    $socket = @fsockopen( $host, $porta, $errno, $errstr, 30 );
    if (!$socket) {
        return(false);
    } else {
        fwrite ($socket, "HEAD ".$path_documento." HTTP/1.0\r\nHost: $host\r\n\r\n");
        $http_response = fgets( $socket, 22 );
        $pos = null;       
	    $pos = strpos($http_response, "200 OK");
        if ( !empty($pos) ) {
            fclose( $socket );       
            return(true);
        } else {
        	//echo "HTTP-Response: $http_response<br>";
            return(false);
        }
    }
} 