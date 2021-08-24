<?php

namespace app\classes;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


class Email
{
    private $mail;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function bemVindo(string $nome, string $email, string $senha, string $link_site)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'oi@automatizadelivery.com';
            $this->mail->Password = '1@ut98l1znapp0xl';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            $this->mail->setFrom('benvindo@automatizadelivery.com.br', utf8_decode('Automatiza Delivery'));
            $this->mail->addAddress($email, $nome);

            $this->mail->isHTML(true);
            $this->mail->Subject = utf8_decode('Bem-vindo(a) a Automatiza Delivery! 🎉');
            $this->mail->Body = utf8_decode('
            <div leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"
    style="height:auto !important;width:100% !important; font-family: Helvetica,Arial,sans-serif !important; margin-bottom: 40px; margin:0; padding:0; background-color:#f8f8f8;">
    <center style="padding-top: 30px;">
        <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0"
            style="max-width:600px; background-color:#ffffff;border:1px solid #e4e2e2;border-collapse:separate !important; border-radius:4px;border-spacing:0;color:#242128; margin:0;padding:40px;"
            heigth="auto">
            <tbody>
                <tr>
                    <td align="left" valign="center"
                        style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                        <img src="https://automatizadelivery.com.br/img/logo.png" style="width: 180px;" width="200px">
                    </td>
                    <td align="right" valign="center"
                        style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                        <span
                            style="color: #8f8f8f; font-weight: normal; line-height: 2; font-size: 14px;">'.date('d/m/Y').'</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:10px;border-top:1px solid #e4e2e2">
                        <h3 style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">'.$nome.',</h3>
                        <p style="color:#8f8f8f; font-size: 14px; padding-bottom: 20px; line-height: 1.4;">
                            Estamos muito felizes em ter você conosco. 😉
                            <br><br>
                            Mantendo nosso compromisso com uma experiência incrível, nos empenhamos em levar o melhor da tecnologia para seu estabelecimento, contribuindo para o seu sucesso.                       
                        </p>
                        <h3 style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">Antes de começar, gostaríamos de dar algumas instruções:</h3>

                        <p style="color:#8f8f8f; font-size: 14px; padding-bottom: 20px; line-height: 1.4;">Acesso ao painel de controle Automatiza Delivery</p>

                        <p style="color:#8f8f8f; font-size: 14px; padding-bottom: 20px; line-height: 1.4;">
                            O acesso ao painel deverá ser feito através do endereço: <a href="https://automatizadelivery.com.br/'.$link_site.'/admin">www.automatizadelivery.com.br/'.$link_site.'/admin</a><br><br>Lá você poderá criar e gerenciar produtos, pedidos, gestão dos usuários e muito mais! :)</p><h3 style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">Dados de acesso:</h3>

                        <p style="background-color:#f1f1f1; padding: 8px 15px; border-radius: 50px; display: inline-block; margin-bottom:20px; font-size: 14px;  line-height: 1.4; font-family: Courier New, Courier, monospace; margin-top:0">
                            E-mail: '.$email.'</p>
                            <div></div>
                        <p style="background-color:#f1f1f1; padding: 8px 15px; border-radius: 50px; display: inline-block; margin-bottom:20px; font-size: 14px;  line-height: 1.4; font-family: Courier New, Courier, monospace; margin-top:0">
                                Senha: 🔒  '.$senha.'</p>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <table style="margin-top:30px; padding-bottom:20px;; margin-bottom: 40px;">
            <tbody>
                <tr>
                    <td align="center" valign="center">
                        
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
    </div>');
            $this->mail->send();
        } catch (Exception $e) {
            echo " Não foi possível enviar o email.";
        }
    }

    public function plano(string $nome, string $email, string $plano)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'oi@automatizadelivery.com';
            $this->mail->Password = '1@ut98l1znapp0xl';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            $this->mail->setFrom('plano@automatizadelivery.com.br', utf8_decode('Automatiza Delivery'));
            $this->mail->addAddress($email, $nome);

            $this->mail->isHTML(true);
            $this->mail->Subject = utf8_decode('Bem-vindo(a) a Automatiza Delivery! 🎉');
            $this->mail->Body = utf8_decode('
            <div leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"
    style="height:auto !important;width:100% !important; font-family: Helvetica,Arial,sans-serif !important; margin-bottom: 40px; margin:0; padding:0; background-color:#f8f8f8;">
    <center style="padding-top: 30px;">
        <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0"
            style="max-width:600px; background-color:#ffffff;border:1px solid #e4e2e2;border-collapse:separate !important; border-radius:4px;border-spacing:0;color:#242128; margin:0;padding:40px;"
            heigth="auto">
            <tbody>
                <tr>
                    <td align="left" valign="center"
                        style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                        <img src="https://automatizadelivery.com.br/img/logo.png" style="width: 180px;" width="200px">
                    </td>
                    <td align="right" valign="center"
                        style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                        <span
                            style="color: #8f8f8f; font-weight: normal; line-height: 2; font-size: 14px;">'.date('d/m/Y').'</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:10px;border-top:1px solid #e4e2e2">
                        <h3 style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">'.$nome.',</h3>
                        <p style="color:#8f8f8f; font-size: 14px; padding-bottom: 20px; line-height: 1.4;">
                            Passando novamente para te ayualizar do plano que contratou.
                            <br><br>
                            Você acaba de contratar o <strong>'.$plano.'</strong> mensal com vigência de acordo com nossos TERMOS DA PLATAFORMA, que você encontra em nosso site <a href="https://automatizadelivery.com.br">automatizadelivery.com.br</a>.
                            <br><br>
                            Para mais informações entre em contato atraves de nossos canais de atendimento.
                        </p>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <table style="margin-top:30px; padding-bottom:20px;; margin-bottom: 40px;">
            <tbody>
                <tr>
                    <td align="center" valign="center">
                        
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
    </div>');
            $this->mail->send();
        } catch (Exception $e) {
            echo " Não foi possível enviar o email.";
        }
    }

    

    public function contatoInteresse(string $nome, string $email, string $telefone, string $empresa, string $plano, string $msn)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'oi@automatizadelivery.com';
            $this->mail->Password = '1@ut98l1znapp0xl';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            $this->mail->setFrom('contato@automatizadelivery.com.br', utf8_decode('Automatiza Delivery'));
            $this->mail->addAddress('atendimento@automatizadelivery.com', 'Atendimento');

            $this->mail->isHTML(true);
            $this->mail->Subject = utf8_decode('Contato Site Delivery');
            $this->mail->Body = utf8_decode('
            <div leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"
    style="height:auto !important;width:100% !important; font-family: Helvetica,Arial,sans-serif !important; margin-bottom: 40px; margin:0; padding:0; background-color:#f8f8f8;">
    <center style="padding-top: 30px;">
        <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0"
            style="max-width:600px; background-color:#ffffff;border:1px solid #e4e2e2;border-collapse:separate !important; border-radius:4px;border-spacing:0;color:#242128; margin:0;padding:40px;"
            heigth="auto">
            <tbody>
                <tr>
                    <td align="left" valign="center"
                        style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                        <img src="https://automatizadelivery.com.br/img/logo.png" style="width: 180px;" width="200px">
                    </td>
                    <td align="right" valign="center"
                        style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                        <span
                            style="color: #8f8f8f; font-weight: normal; line-height: 2; font-size: 14px;">'.date('d/m/Y').'</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:10px;border-top:1px solid #e4e2e2">
                        <h3 style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">Temos um novo Contato!!</h3>
                        <p style="color:#8f8f8f; font-size: 14px; padding-bottom: 20px; line-height: 1.4;"><br>
                        Nome: ' . $nome . '<br>Nome: ' . $email . '<br>Telefone: ' . $telefone .'<br>Empresa: ' . $empresa .'<br>Plano: ' . $plano . '<br>Mensagem: ' . $msn . '
                        </p>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <table style="margin-top:30px; padding-bottom:20px;; margin-bottom: 40px;">
            <tbody>
                <tr>
                    <td align="center" valign="center">
                        
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
    </div>');
            $this->mail->send();
        } catch (Exception $e) {
            echo " Não foi possível enviar o email.";
        }
    }


    public function contato(string $nome, string $email, string $telefone, string $msn)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'oi@automatizadelivery.com';
            $this->mail->Password = '1@ut98l1znapp0xl';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            $this->mail->setFrom('contato@automatizadelivery.com.br', utf8_decode('Automatiza Delivery'));
            $this->mail->addAddress('atendimento@automatizadelivery.com', 'Atendimento');

            $this->mail->isHTML(true);
            $this->mail->Subject = utf8_decode('Contato Site Delivery');
            $this->mail->Body = utf8_decode('
            <div leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"
    style="height:auto !important;width:100% !important; font-family: Helvetica,Arial,sans-serif !important; margin-bottom: 40px; margin:0; padding:0; background-color:#f8f8f8;">
    <center style="padding-top: 30px;">
        <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0"
            style="max-width:600px; background-color:#ffffff;border:1px solid #e4e2e2;border-collapse:separate !important; border-radius:4px;border-spacing:0;color:#242128; margin:0;padding:40px;"
            heigth="auto">
            <tbody>
                <tr>
                    <td align="left" valign="center"
                        style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                        <img src="https://automatizadelivery.com.br/img/logo.png" style="width: 180px;" width="200px">
                    </td>
                    <td align="right" valign="center"
                        style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                        <span
                            style="color: #8f8f8f; font-weight: normal; line-height: 2; font-size: 14px;">'.date('d/m/Y').'</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:10px;border-top:1px solid #e4e2e2">
                        <h3 style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">Temos um novo Contato!!</h3>
                        <p style="color:#8f8f8f; font-size: 14px; padding-bottom: 20px; line-height: 1.4;"><br>
                        Nome: ' . $nome . '<br>Nome: ' . $email . '<br>Telefone: ' . $telefone . '<br>Mensagem: ' . $msn . '
                        </p>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <table style="margin-top:30px; padding-bottom:20px;; margin-bottom: 40px;">
            <tbody>
                <tr>
                    <td align="center" valign="center">
                        
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
    </div>');
            $this->mail->send();
        } catch (Exception $e) {
            echo " Não foi possível enviar o email.";
        }
    }



    public function recuperacaoSenha(string $nome, string $email, int $id, string $link_site)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'oi@automatizadelivery.com';
            $this->mail->Password = '1@ut98l1znapp0xl';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;

            $this->mail->setFrom('benvindo@automatizadelivery.com.br', utf8_decode('Automatiza Delivery'));
            $this->mail->addAddress($email, $nome);

            $this->mail->isHTML(true);
            $this->mail->Subject = utf8_decode('Recuperação de senha - Automatiza Delivery! 🔐');
            $this->mail->Body = utf8_decode('<div leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"
            style="height:auto !important;width:100% !important; font-family: Helvetica,Arial,sans-serif !important; margin-bottom: 40px; margin:0; padding:0; background-color:#f8f8f8;">
            <center style="padding-top: 30px;">
                <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0"
                    style="max-width:600px; background-color:#ffffff;border:1px solid #e4e2e2;border-collapse:separate !important; border-radius:4px;border-spacing:0;color:#242128; margin:0;padding:40px;"
                    heigth="auto">
                    <tbody>
                        <tr>
                            <td align="left" valign="center"
                                style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                                <img src="https://automatizadelivery.com.br/img/logo.png" style="width: 180px;" width="200px">
                            </td>
                            <td align="right" valign="center"
                                style="padding-bottom:40px;border-top:0;height:100% !important;width:100% !important;">
                                <span
                                    style="color: #8f8f8f; font-weight: normal; line-height: 2; font-size: 14px;">'.date('d/m/Y').'</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top:10px;border-top:1px solid #e4e2e2">
                                <h3 style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">'.$nome.',</h3>
                                <p style="color:#8f8f8f; font-size: 14px; padding-bottom: 20px; line-height: 1.4;">
                                    Você solicitou uma recuperação de senha, para alterar clique no botão abaixo!                    
                                </p>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top:30px;" align="center">
                                <a href="https://automatizadelivery.com.br/'.$link_site.'/recuperar/98e4011142eeb9842091bf4812f81656a7d80eac/'.$id.'" title="Cadastrar nova senha" target="_blank" style="font-size: 14px; line-height: 1.5; font-weight: 700; letter-spacing: 1px; padding: 15px 40px; text-align:center; text-decoration:none; color:#FFFFFF; border-radius: 50px; background-color:#880A1F;">Cadastrar nova senha</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="margin-top:30px; padding-bottom:20px;; margin-bottom: 40px;">
                    <tbody>
                        <tr>
                            <td align="center" valign="center">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
        </div>');
            $this->mail->send();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}