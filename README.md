<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://i.ibb.co/t84wtb7/p6-UVIf-Jyzbp-Sz-Bt-Kl-Xdg-P4i34-An-NOAp3rmck-DUe-S.png" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Viper Pro

Viperpro é um projeto de código aberto desenvolvido em PHP utilizando o Framework Laravel 10 e Vue 3,
com várias integrações com diferentes provedores de iGaming. Este projeto é destinado para fins de estudo.
Use-o com responsabilidade e consciência, e não o utilize para fins fraudulentos. 

Recursos:

- Autenticação com Google.
- Sistema de Afiliados com RevShare e CPA.
- Integração com Games Slotegrator.
- Integração com Games Salsa.
- Integração com Games Ever.
- Integração com Games Worldslote.
- Integração com Games Fivers, método Seamless
- Sistema de Notificação.
- Painel de Controle.
- Painel Administrativo.
- Painel de Afiliados.
- Sistema de customização
- Gateway de Pagamento DigitoPay. Contato para abertura de contas: [048 98814-2566](https://api.whatsapp.com/send?phone=5504898814256)
- Customização dos Banners e Slide.

Muitas pessoas buscam desenvolvedores para trabalhar em projetos e acabam sendo vítimas de golpes. 
Ao procurar um programador, solicite referências e um portfólio para garantir a segurança e a qualidade do serviço. Ou
Solicite um orçamento com nossos [Desenvolvedores Oficiais](https://viper.casino/)

## Melhorias e Correções

O Viper Pro está passando por diversas melhorias para prevenir ataques hackers e proteger os usuários contra ações maliciosas.
Caso você detecte algum bug ou falha de segurança, por favor, entre em contato através do site oficial. Resolveremos
o problema imediatamente e sem nenhum custo. Algumas falhas, listadas abaixo, já foram corrigidas.

### Problemas com rotas do admin, sendo acessadas pelo painel de afiliados.

Esse problema ocorria devido à ausência de uma validação separada, permitindo que algumas páginas do 
administrador fossem acessadas pelo painel de afiliado usando a mesma sessão e função. A seguir, explicamos as 
medidas que tomamos para resolver essa questão.

#### Novos middlewares foram criados para permitir bloqueios e validações individuais nos painéis.
- CheckAdmin 
- CheckAffiliate

#### Envio de Requisições no Provedor Ever, Worldslot e PlayGaming
Para evitar que dados de vitória sejam enviados via requisição e o saldo seja fraudado, implementamos um sistema 
de tokens para validar as transações recebidas.

#### Gateway de Pagamento - Digito Pay

1. Mudanças 
Anteriormente, enviávamos apenas o ID da transação para o front-end para consulta de status. Agora, enviamos tanto o ID da 
transação quanto o ID de verificação, o que permite realizar a chamada da transação com maior segurança.

2. Melhorias
Agora, na confirmação de depósito pelo webhook, realizamos uma verificação adicional para garantir que o pagamento foi realmente aprovado.

3. Webhook automaticado
Agora o webhook da digitopay é automaticamente configurado.


## [VIPER PRO 2.0](https://viper.casino/)
O projeto Viper Pro foi totalmente reformulado pela nova equipe Viper, da qual não faço mais parte. No entanto, posso garantir que vocês estão em boas mãos, com os melhores profissionais do iGaming.

SE VOCÊ NÃO É DESENVOLVEDOR E DESEJA UMA PLATAFORMA DE ALTA QUALIDADE, COM ATUALIZAÇÕES E MELHORIAS CONSTANTES, TANTO NO VISUAL QUANTO NO BACKEND, ADQUIRA SUA WHITE LABEL AGORA MESMO.

[COMPRAR AQUI](https://viper.casino/)

CLIENTES VIPER PRO V1 NÃO PAGAM PELA LICENÇA NA AQUISIÇÃO DA VIPER PRO 2.0. VALE A PENA MIGRAR, FICOU INCRIVEL
O NOVO PROJETO.

## Correções
Para qualquer dúvida ou relato de bugs, por favor, deixe-os aqui no GitHub. Farei o possível para resolver o mais rápido possível.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
