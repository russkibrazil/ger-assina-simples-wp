<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
        header("location: log.php");
        exit;
}
require_once "../script/conf.php";
require_once ("../script/classTexto.php");
$sql = "SELECT display_name FROM abpee03.wp_users WHERE id=" . $_SESSION["id"];
if($stmt = $mysqli->prepare($sql)){
        if($stmt->execute()){
                $stmt->store_result();
                $stmt->bind_result($nome);
                $stmt->fetch();
        }
        else{ echo "Erro na execução";}
}
else{ echo "Erro no preparo";}
?>
<!DOCTYPE html>
<html>
    <header>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" type="text/css" href="estilo.css">
    </header>
    <body>
        <nav class="navbar navbar-expand-md navbar-light  bg-light">
                <div class="navbar-header">
                        <a class="navbar-brand" href="#"  style="color: lightgreen; font-weight: 900;">Abpee</a>
                </div>
                <ul class="navbar-nav ">
                                   <li class="nav-item "><a href="../log.php" class="nav-link">Home</a></li>
                  <li class="nav-item"><a href="javascript:window.print()" class="nav-link btn btn-primary"><span class="fas fa-file-pdf" style="color: white;"></span><span class="fas fa-print"style="color: white;"></span>Imprimir/Gerar PDF</a></li>
                  <li class="nav-item"><a href="../logout.php" class="nav-link"><span class="fas fa-power-off"></span>Sair</a></li>
                </ul>
        </nav>
        <div id="borda">
            <div id="conteudo">
                <h1 id="sigla" class="texto-dir">Abpee</h1>
                <h3 id="extenso" class="texto-centro">ASSOCIAÇÃO BRASILEIRA DE PESQUISADORES EM EDUCAÇÃO ESPECIAL</h3>
                <p id="cnpj" class="texto-dir">CNPJ 00.359.361/0001-29</p>
                <h2 id="titulo" class="texto-centro">DECLARAÇÃO DE ACESSO GRATUITO</h2>
                <p>Declaro para os devidos fins que o periódico Revista Brasileira de Educação Especial que tem por objetivo os conhecimentos na área de Educação Especial com
                Qualis Qualis A2 , pela Capes área de Educação e A1 na área de Ensino, ISSN: 1980-5470, estabelecendo parcerias através de sua política editorial na construção e
                divulgação da mesma, informa que <?php echo $nome; ?>  terá por tempo indeterminado o acesso gratuito ao periódico online.</p>
                <p>Bauru, <?php setlocale(LC_ALL,array("pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese")); echo date("j") . " de " . strftime("%B") . " de " . date("Y");  ?> </p>
                <br><br><br>
                <?php 
                        $assinatura = glob("../uploads/assinatura.*");
                        if (!(empty($assinatura))){
                                echo "<img src=\"" . $assinatura[0] . "\" class=\"imagem-centro\" id=\"assinatura\" >";
                        }
                ?>
                <p class="texto-centro">Presidente</p>
                <p class="texto-centro">Associação Brasileira de Pesquisadores em Educação Especial</p>
            </div>
            <div id="rodape">
                <b class="">UNESP - Faculdade de Ciências – Campus de Bauru - Departamento de Educação</b>
                <br/>
                <b>ABPEE – Av. Eng. Luiz Edmundo Carrijo Coube 14-01 – Presidente Geisel, Bauru - SP</b>
                <br/>
                <b>www.abpee.net</b>
            </div>
        </div>
        
    </body>
</html>
<?php
$stmt->close();
$mysqli->close();
?>
