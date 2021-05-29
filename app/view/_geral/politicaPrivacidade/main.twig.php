{% extends 'partials/body.twig.php'  %}

{% block title %}Política de Privacidade - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Política de Privacidade</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/perfil"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page mb-3">
    <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
        <div class="full_page">
            <h6 class="mb-1 font-weight-bold full_page">Política de privacidade</h6>

            <p class="pb-0">A aceitação desta Política de Privacidade se dará no ato do seu clique no botão "Aceito", de modo que o usuário concorda e permite o acesso às suas informações a partir de seu cadastro na Plataforma, manifestando consentimento livre, expresso e informado. Se o usuário não concordar com a política de tratamento de dados descrita nesse documento, não deve utilizar a Plataforma.</p>

            <p class="pb-0">O usuário poderá verificar o conteúdo desta Política diretamente por meio do link: <a href="{{empresa.link_site}}/politica-de-privacidade">{{empresa.link_site}}/politica-de-privacidade</a></p>

            <p class="pb-0">Caso reste alguma dúvida entre em contato conosco, pelo e-mail <a href="mailto:{{empresa[':emailContato']}}">{{empresa[':emailContato']}}</a></p>

            <h6 class="mt-3 mb-2 font-weight-bold full_page">1. Dados coletados</h6>

            <p class="pb-0">A <strong>{{empresa[':razaoSocial']}}</strong> coleta todos os dados inseridos pelo usuário na Plataforma, tais como dados cadastrais, pedidos, comentários etc. São coletados pela <strong>{{empresa[':razaoSocial']}}</strong> todos os dados ativamente disponibilizadas pelo usuário na utilização da Plataforma.</p>

            <p class="pb-0">A <strong>{{empresa[':razaoSocial']}}</strong> também coleta algumas informações automaticamente quando o usuário acessa e utiliza a Plataforma, tais como características do dispositivo de acesso, do navegador, Protocolo de Internet (IP, com data e hora), origem do IP, informações sobre cliques, páginas acessadas, as páginas seguintes acessadas após a saída da Plataforma, ou qualquer termo de busca digitado na Plataforma, dentre outros. A <strong>{{empresa[':razaoSocial']}}</strong> também poderá utilizar algumas tecnologias padrões para coletar informações do usuário, tais como cookies, pixel tags e local shared objects, de modo a melhorar sua experiência de navegação.</p>

            <p class="pb-0">O usuário pode, a qualquer momento, bloquear algumas destas tecnologias para coleta automática de dados através do seu navegador. Nesse caso é possível que algumas das funções oferecidas pela Plataforma deixem de funcionar corretamente.</p>

            <p class="pb-0">Desta forma, o usuário desde já se encontra ciente acerca das informações coletadas por meio da Plataforma e expressa consentimento livre, expresso e informado com relação à coleta de tais informações.</p>

            <h6 class="mt-3 mb-2 font-weight-bold full_page">2. Finalidade dos dados coletados</h6>

            <p class="pb-0">A <strong>{{empresa[':razaoSocial']}}</strong> considera todos os dados coletados por meio da Plataforma como confidenciais. Portanto, somente as utilizará da forma aqui descrita e autorizada pelo usuário. Todos os dados cadastrados e coletados na Plataforma são utilizados para a prestação de serviços pela <strong>{{empresa[':razaoSocial']}}</strong>, para melhorar a experiência de navegação do usuário na Plataforma, bem como para fins de marketing.</p>

            <p class="pb-0">A <strong>{{empresa[':razaoSocial']}}</strong> poderá trabalhar com empresas terceirizadas para a divulgação de anúncios aos usuários durante seu acesso à Plataforma. Tais empresas poderão coletar informações sobre as visitas de usuários à Plataforma, no intuito de fornecer anúncios personalizados sobre bens e serviços do interesse do usuário. Tais informações não incluem nome, endereço, e-mail ou número de telefone do usuário.</p>

            <p class="pb-0">O usuário dá o consentimento livre, expresso e informado para que a <strong>{{empresa[':razaoSocial']}}</strong> e seus parceiros utilizem as informações coletadas por meio da Plataforma para fins publicitários e comerciais, bem como para adequada prestação de serviços pela <strong>{{empresa[':razaoSocial']}}</strong>.</p>

            <p class="pb-0">O usuário que não desejar receber mais e-mails promocionais e de comunicação, deverá enviar um e-mail para <a href="mailto:{{empresa[':emailContato']}}">{{empresa[':emailContato']}}</a>, solicitando o não recebimento dessas mensagens ou então ele próprio realizar sua exclusão através dos links disponibilizados nos e-mails.</p>

            <p class="pb-0">Importante lembrar que a Plataforma pode conter links para outras páginas, que possuem Política de Privacidade com previsões diversas do disposto neste documento. Dessa forma, a <strong>{{empresa[':razaoSocial']}}</strong> não se responsabiliza pela coleta, utilização, compartilhamento e armazenamento de dados dos usuários pelos responsáveis por tais páginas.</p>

            <h6 class="mt-3 mb-2 font-weight-bold full_page">3. Com quem são compartilhados os dados dos usuários</h6>

            <p class="pb-0">A <strong>{{empresa[':razaoSocial']}}</strong> poderá compartilhar os dados coletados por meio da Plataforma, nas seguintes situações:</p>

            <p class="pb-0">Com empresas parceiras da <strong>{{empresa[':razaoSocial']}}</strong>, para fins publicitários, conforme descrito no item 2 acima;
            Quando necessário às atividades comerciais da <strong>{{empresa[':razaoSocial']}}</strong>, como por exemplo, mas não se limitando à, operadoras de cartão de crédito, para o recebimento de pagamentos;
            Para proteção dos interesses da <strong>{{empresa[':razaoSocial']}}</strong> em qualquer tipo de conflito, incluindo ações judiciais;
            No caso de transações e alterações societárias envolvendo <strong>{{empresa[':razaoSocial']}}</strong>, hipótese em que a transferência das informações será necessária para a continuidade dos serviços;
            Mediante ordem judicial ou pelo requerimento de autoridades administrativas que detenham competência legal para sua requisição.
            Armazenamento das Informações
            As informações dos usuários serão armazenadas pela <strong>{{empresa[':razaoSocial']}}</strong>, em servidores próprios ou por ela contratados.</p>

            <h6 class="mt-3 mb-2 font-weight-bold full_page">4. Segurança</h6>

            <p class="pb-0">A <strong>{{empresa[':razaoSocial']}}</strong> emprega todos os esforços de mercado para garantir a segurança de seus sistemas na guarda de referidos dados, tais como:</p>

            <p class="pb-0">Utilização de métodos padrões e de mercado para criptografar e anonimizar os dados coletados;
            Utilização de software de proteção contra acesso não autorizado aos nossos sistemas;
            Autorização de acesso somente a pessoas previamente estabelecidas aos locais onde armazenamos as informações;
            Aqueles que entrarem em contato com as informações deverão se comprometer a manter sigilo absoluto. A quebra do sigilo acarretará responsabilidade civil e o responsável será processado nos moldes da legislação brasileira.
            Esta Política representa esforço da <strong>{{empresa[':razaoSocial']}}</strong> no sentido de resguardar as informações dos usuários de sua Plataforma. No entanto, em razão da própria natureza da Internet, não é possível garantir que terceiros mal intencionados não obtenham sucesso em acessar indevidamente as informações armazenadas.</p>

            <p class="pb-0">A <strong>{{empresa[':razaoSocial']}}</strong> adota medidas de segurança adequadas para proteger-se contra acesso não autorizado, alteração, divulgação ou destruição dos dados pessoais do usuário por nós coletados e armazenados. Essas medidas variam com base no tipo e na confidencialidade dos dados. Infelizmente, no entanto, nenhum sistema pode ser 100% protegido. Por isso, não podemos garantir que as comunicações entre o usuário e a <strong>{{empresa[':razaoSocial']}}</strong>, os Serviços ou qualquer informação fornecida à <strong>{{empresa[':razaoSocial']}}</strong> em relação aos dados por nós coletados por meio dos Serviços estejam livres de acesso não autorizado por terceiros. A senha do usuário é uma parte importante do nosso sistema de segurança, e é responsabilidade do usuário protegê-la. Não compartilhe a senha com terceiros. Em caso de suspeita de violação da senha ou conta, altere-a imediatamente e entre em contato com <a href="mailto:{{empresa[':emailContato']}}">{{empresa[':emailContato']}}</a> para sanar a situação.</p>

            <h6 class="mt-3 mb-2 font-weight-bold full_page">5. Exclusão das informações</h6>

            <p class="pb-0">Mediante solicitação do usuário, pelo email <a href="mailto:{{empresa[':emailContato']}}">{{empresa[':emailContato']}}</a>, as informações referidas na presente Política serão excluídas pela <strong>{{empresa[':razaoSocial']}}</strong> quando deixarem de ser úteis aos propósitos para os quais foram coletadas.</p>

            <p class="pb-0">A <strong>{{empresa[':razaoSocial']}}</strong> fará os melhores esforços para atender a todos os pedidos de exclusão, no menor espaço de tempo possível. Tal exclusão, no entanto, removerá também o cadastro do usuário da Plataforma, que não conseguirá mais acessá-la, inclusive no que diz respeito aos conteúdos por ele assistidos.</p>

            <p class="pb-0">Porém, o usuário deve estar ciente de que, mesmo em caso de requisição de exclusão, a <strong>{{empresa[':razaoSocial']}}</strong> respeitará o prazo de armazenamento mínimo de informações determinado pela legislação brasileira.</p>

            <h6 class="mt-3 mb-2 font-weight-bold full_page">6. Atualização desta política</h6>

            <p class="pb-0">Reservamo-nos o direito de alterar essa Política de Privacidade sempre que necessário, como objetivo de fornecer maior segurança e praticidade ao usuário, o que poderá se dar sem prévia notificação ao usuário, salvo em caso de expressa vedação legal. Por isso é importante que o usuário leia a Política a cada nova atualização, conforme data de modificação informada ao final deste documento.</p>

            <h6 class="mt-3 mb-2 font-weight-bold full_page">7. Legislação e foro competentes</h6>

            <p class="pb-0">Essa Política de Privacidade será regida, interpretada e executada de acordo com as leis da República Federativa do Brasil, independentemente dos conflitos dessas leis com leis de outros estados ou países, sendo competente o Foro do local de residência do usuário, no Brasil, para dirimir qualquer dúvida decorrente deste instrumento. O usuário consente, expressamente, com a competência desse juízo, e renuncia, neste ato, à competência de qualquer outro foro, por mais privilegiado que seja ou venha a ser.</p>
        </div>
    </div>
    </div>

</div>
{% include 'partials/footer.twig.php' %}
{% endblock %}