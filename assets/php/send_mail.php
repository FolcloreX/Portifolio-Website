<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Certifique-se de que o PHPMailer está carregado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Configuração do PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();                                      // Enviar via SMTP
        $mail->Host = 'smtp.gmail.com';                        // Defina o servidor SMTP do Gmail
        $mail->SMTPAuth = true;                               // Ativar autenticação SMTP
        $mail->Username = 'seu-email@gmail.com';              // Seu e-mail do Gmail
        $mail->Password = 'sua-senha-de-aplicativo';          // Sua senha de aplicativo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Ativar criptografia TLS
        $mail->Port = 587;                                    // Porta SMTP do Gmail

        // Remetente
        $mail->setFrom($email, $name);  // E-mail e nome do remetente
        $mail->addAddress('destinatario@dominio.com', 'Nome Destinatário'); // E-mail do destinatário

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = 'Nova mensagem de ' . $name;
        $mail->Body    = 'Você recebeu uma nova mensagem do seu formulário de contato:<br><br>';
        $mail->Body   .= 'Nome: ' . $name . '<br>';
        $mail->Body   .= 'E-mail: ' . $email . '<br>';
        $mail->Body   .= 'Mensagem: <br>' . nl2br($message);

        // Envia o e-mail
        $mail->send();
        echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
?>
