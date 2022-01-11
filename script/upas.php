<?php
//https://code.tutsplus.com/tutorials/how-to-upload-a-file-in-php-with-example--cms-31763
$target_dir = "../uploads/";
//$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
$target_file = $target_dir . "assinatura." . strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
$uploadOk = true;
if(isset($_POST["uplAss"])) {
	if(isset($_FILES["fileToUpload"]) &&  $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK){
		$check = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
		$mime_permitido = array("image/gif","image/jpeg","image/png");
		if(!(in_array($check,$mime_permitido))) {
			$uploadOk = false;
		}
		if ($_FILES["fileToUpload"]["size"] > 350000) {
			echo "O arquivo é muito grande para o envio.";
			$uploadOk = false;
		}
		if (!(uploadOk) ) {
			echo "Arquivo não enviado devido a erros.";
		} else {
			$arqex = glob("../uploads/assinatura.*");
			if (!(empty($arqex) )) {
				foreach ($arqex as $prt ){
					try{
						unlink($prt);
					}catch(Exception $e){
					}
				}
			}
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) { 
				echo "O arquivo <b><i>". basename( $_FILES["fileToUpload"]["name"]). "</i></b> foi enviado e está pronto para uso.";
			} else {
				echo "Houve problemas no processamento do arquivo e o procedmento foi abortado.";
			}
		}
	}
}
?>
