Funcionalidade: Gerenciamento de viagens
  Como um administrador do sistema
  Eu quero gerenciar viagens
  Para organizar os serviços de transporte

  Cenário: Criar uma nova viagem
    Dado que estou logado como administrador
    E estou na página de viagens
    Quando eu clico no botão "Nova Viagem"
    E preencho o nome "Viagem para São Paulo"
    E seleciono a origem "Rio de Janeiro"
    E seleciono o destino "São Paulo"
    E preencho a data de partida "25/12/2024"
    E preencho o horário de partida "08:00"
    E preencho o preço "150.00"
    E seleciono um veículo disponível
    E seleciono um motorista disponível
    E clico no botão "Salvar"
    Então devo ver a mensagem "Viagem criada com sucesso"
    E a viagem deve aparecer na lista de viagens

  Cenário: Editar uma viagem existente
    Dado que existe uma viagem "Viagem para São Paulo"
    E estou logado como administrador
    E estou na página de viagens
    Quando eu clico em "Editar" na viagem "Viagem para São Paulo"
    E altero o nome para "Viagem Rio-São Paulo Atualizada"
    E altero o preço para "200.00"
    E clico no botão "Atualizar"
    Então devo ver a mensagem "Viagem atualizada com sucesso"
    E a viagem deve ter o novo nome na lista

  Cenário: Cancelar uma viagem
    Dado que existe uma viagem "Viagem para São Paulo" em andamento
    E estou logado como administrador
    E estou na página de viagens
    Quando eu clico em "Cancelar" na viagem "Viagem para São Paulo"
    E confirmo o cancelamento
    Então devo ver a mensagem "Viagem cancelada com sucesso"
    E a viagem deve aparecer como cancelada na lista

  Cenário: Buscar viagens por destino
    Dado que existem viagens para "São Paulo" e "Brasília"
    E estou logado como administrador
    E estou na página de viagens
    Quando eu digito "São Paulo" no campo de busca
    E clico no botão "Buscar"
    Então devo ver apenas as viagens para São Paulo
    E não devo ver as viagens para Brasília
