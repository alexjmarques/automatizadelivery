$("#carregar").delay(2000).fadeOut("slow");
//$(document).ready(function(){
        $('#btn-cadastro').click(function(event){
            event.preventDefault();

            let nome = $('#nome').val();

            // if(nome.match(/^[a-zA-Z\u00C0-\u017F´]+\s+[a-zA-Z\u00C0-\u017F´]{0,}$/) && nome.trim().split(' ').length){
            //  }else{
            //     $('#mensagem').addClass('alert alert-danger text-danger').show('fade').text('Ooops! Preencha com seu Nome e Sobrenome');
            //     exit();
            //  }

            let telefone = $('#telefone').val();
            let email = $('#email').val();
            let politicaPrivacidade = $("#politicaPrivacidade").is(':checked');
            let senha = $('#senha').val();

            if(nome === "" || telefone === "" || email === "" || senha === "" || politicaPrivacidade === false){
                $('#mensagem').text('Todos os campos são Obrigatórios');
            }else{
                $.ajax({
                    url: "cadastrar-usuario.php",
                    method: "post",
                    data: $('form').serialize(),
                    dataType: "text",
                    success: function(mensagem){
    
                        $('#mensagem').removeClass()
                        if(mensagem == 'Cadastrado com Sucesso!!'){
                            $('#mensagem').addClass('text-success')
                            document.getElementById('username').value = document.getElementById('email').value;
                            document.getElementById('pass').value = document.getElementById('senha').value;
                            $('#nome').val('')
                            $('#telefone').val('')
                            $('#email').val('')
                            $('#senha').val('')
                            window.location = 'cadastrado-sucesso.php';
                        }else{
                            $('#mensagem').addClass('text-danger')
                        }
                        $('#mensagem').text(mensagem)
    
                    },
                    
                })
            }
        })
    ////})

    $(document).ready(function(){
        $('#btn-rec').click(function(event){
            event.preventDefault();
            $.ajax({
                url: "inc/recuperar.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(mensagem){
                    $('#mensagem2').removeClass()
                    if(mensagem == 'Dentro de instantes, receberá em seu email instruções para recuperar a sua senha!!'){
                        $('#mensagem2').addClass('text-success')

                        //window.location.href = `login.php`;
                        $('#email-recuperar').val('')
                    }else{
                        $('#mensagem2').addClass('text-danger')
                    }
                    
                    $('#mensagem2').text(mensagem)

                },
                
            })
        })


        $('#btn-rec-up').click(function(event){
            event.preventDefault();
            $.ajax({
                url: "inc/recuperar-up.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(mensagem){
                    if(mensagem == 'Senha atualizada com Sucesso!!'){
                        $('#mensagem').text(mensagem)
                        window.location.href = `login.php`;
                    }else{
                        $('#mensagem').text(mensagem )
                    }
                    $('#mensagem').text(mensagem)

                },
                
            })
        })
    })