<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
        header("location: log.php");
        exit;
}
require_once "../script/conf.php";
require_once ("../script/classTexto.php");
$sql = "SELECT display_name, ultimo_pgto FROM abpee03.wp_users WHERE id=" . $_SESSION["id"];
if($stmt = $mysqli->prepare($sql)){
        if($stmt->execute()){
                $stmt->store_result();
                $stmt->bind_result($nome, $datap);
                $stmt->fetch();
        }
        else{ echo "Erro na execução";}
}
else{ echo "Erro no preparo";}
?>
<!DOCTYPE html>

<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#faq">
  Ajuda
</button>
-->


<html>
    <header>
        <meta charset="utf-8">
        <title>Recibo de quitação -- Abpee</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" type="text/css" href="estilo.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </header>
    <body>
        <nav class="navbar navbar-expand-md navbar-light  bg-light">
                <div class="navbar-header">
                        <a class="navbar-brand" href="#"  style="color: lightgreen; font-weight: 900;">Abpee</a>
                </div>
                <ul class="navbar-nav ">
                  <li class="nav-item "><a href="../log.php" class="nav-link">Home</a></li>
                  <li class="nav-item"><a href="javascript:window.print()" class="nav-link btn btn-primary" style="color:white;"><span class="fas fa-file-pdf" style="color: white;"></span><span class="fas fa-print"style="color: white;"></span>Imprimir/Gerar PDF</a></li>
                  <li class="nav-item"><a href="" class="nav-link" data-toggle="modal" data-target="#faq"><span class="fas fa-help"></span>Ajuda</a></li>
                  <li class="nav-item"><a href="../logout.php" class="nav-link"><span class="fas fa-question-circle"></span>Sair</a></li>
                </ul>
        </nav>
        
        <!-- Modal -->
        <div class="modal fade" id="faq" tabindex="-1" role="dialog" aria-labelledby="faq" aria-hidden="true">
                <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title" id="faqTitulo">Perguntas frequentes</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                        <h4>Meu nome está incompleto ou escrito incorretamente.</h4>
                                        <p>O nome aqui inserido é recuperado diretamente do seu cadastro no site da Abpee. Vá até <a href="https://abpee.net/wp/wp-admin/profile.php" target="_blank">seu perfil interno do Wordpress</a> e altere a opção <b>Exibir o nome publicamente como</b> para uma que represente seu nome completo. </p>
                                        <p>Feita a mudança, emita um novo documento e você verá o nome conforme configurado.</p> 
                                        <h4>Meu ano de pagamento está estranho</h4>
                                        <p>Para que o ano surja corretamente, um administrador precisa constar na plataforma que você está em dia com a sua taxa de sócio, caso você já a tenha paga. Entre em contato conosco direto no nosso site se achar que a confirmação está demorando muito.</p>
                                        <h4>Não vejo a opção para emitir um arquivo PDF</h4>
                                        <p>Caso seu sistema não possua uma impressora virtual de arquivos PDF, é necessário instalar um software que disponibilize uma para você.</p>
                                        <p>Recomendamos o uso do Foxit Reader. <a href="https://www.foxitsoftware.com/pt-br/downloads/" target="_blank">Clicando neste link</a>, você será redirecionado para a página de downloads do desenvolvedor.</p>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                        </div>
                </div>
        </div>
        
        <!-- relatorio -->
        <div id="borda">
            <div id="conteudo">
                <h1 id="sigla" class="texto-dir">Abpee</h1>
                <h3 id="extenso" class="texto-centro">ASSOCIAÇÃO BRASILEIRA DE PESQUISADORES EM EDUCAÇÃO ESPECIAL</h3>
                <p id="cnpj" class="texto-dir">CNPJ 00.359.361/0001-29</p>
                <br><br>
                <h2 id="titulo" class="texto-centro">DECLARAÇÃO</h2>
                <br><br>
                <p>Declaro para os devidos fins que <?php echo $nome; ?> é sócio ativo da Associação Brasileira de Pesquisadores em Educação Especial – ABPEE no ano de <?php 
                echo date("Y", strtotime($datap)) . " (" . classTexto::valorPorExtenso(date("Y",strtotime($datap)), false, false); 
                ?>) e encontra-se quite com a anuidade no ano referido.</p>
                <p>Bauru, <?php setlocale(LC_ALL,array("pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese")); echo date("j") . " de " . strftime("%B") . " de " . date("Y");  ?> </p>
                <br><br><br>
                <?php 
                        $assinatura = glob("../uploads/assinatura.*");
                        if (!(empty($assinatura))){
                                echo "<img src=\"" . $assinatura[0] . "\" class=\"imagem-centro\" id=\"assinatura\" >";
                        }
                ?>
                <br>
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
$sql = "UPDATE abpee03.wp_users SET ultimo_recibo_quite='". date("Y-m-d H:i:s") . "' WHERE id=" . $_SESSION["id"];
if($stmt = $mysqli->prepare($sql)){
        if(!($stmt->execute())){echo "Erro na execução";}
}else {echo "Erro no preparo da atualização";}
$stmt->close();
$mysqli->close();
?>
