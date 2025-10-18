Funcionalidade: Dashboard do sistema
  Como um usuário logado
  Eu quero visualizar informações importantes
  Para ter uma visão geral do sistema

  Cenário: Acessar dashboard após login
    Dado que estou logado no sistema
    Quando eu acesso a página inicial
    Então devo ver o título "Gerenciamento de viagens - Coinpel"
    E devo ver o menu de navegação
    E devo ver estatísticas do sistema

  Cenário: Navegar pelo menu do dashboard
    Dado que estou logado no sistema
    E estou na página do dashboard
    Quando eu clico no menu "Usuários"
    Então devo ser redirecionado para a página de usuários
    E devo ver a lista de usuários

    Quando eu clico no menu "Motoristas"
    Então devo ser redirecionado para a página de motoristas
    E devo ver a lista de motoristas

    Quando eu clico no menu "Veículos"
    Então devo ser redirecionado para a página de veículos
    E devo ver a lista de veículos

    Quando eu clico no menu "Viagens"
    Então devo ser redirecionado para a página de viagens
    E devo ver a lista de viagens

  Cenário: Visualizar estatísticas do sistema
    Dado que existem dados no sistema:
      | Usuários | 5 |
      | Motoristas | 10 |
      | Veículos | 8 |
      | Viagens Ativas | 3 |
    E estou logado no sistema
    E estou na página do dashboard
    Então devo ver um resumo com:
      | Total de Usuários | 5 |
      | Total de Motoristas | 10 |
      | Total de Veículos | 8 |
      | Viagens em Andamento | 3 |

  Cenário: Acessar funcionalidades rápidas
    Dado que estou logado no sistema
    E estou na página do dashboard
    Quando eu clico no botão "Nova Viagem"
    Então devo ser redirecionado para o formulário de criação de viagem

    Quando eu clico no botão "Novo Motorista"
    Então devo ser redirecionado para o formulário de cadastro de motorista

    Quando eu clico no botão "Novo Veículo"
    Então devo ser redirecionado para o formulário de cadastro de veículo
