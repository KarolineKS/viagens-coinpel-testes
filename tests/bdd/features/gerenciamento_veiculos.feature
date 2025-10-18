Funcionalidade: Gerenciamento de veículos
  Como um administrador do sistema
  Eu quero gerenciar veículos
  Para controlar a frota disponível

  Cenário: Cadastrar um novo veículo
    Dado que estou logado como administrador
    E estou na página de veículos
    Quando eu clico no botão "Novo Veículo"
    E preencho o nome de identificação "AQ 942"
    E preencho o prefixo "AQ"
    E preencho a placa "ABC1234"
    E preencho o modelo "Volvo B290R"
    E preencho o chassi "UT56520747"
    E seleciono o tipo "Micro-ônibus"
    E preencho a capacidade "30"
    E preencho o ano "2022"
    E seleciono o layout "Leito"
    E marco as opções de conforto disponíveis
    E clico no botão "Salvar"
    Então devo ver a mensagem "Veículo cadastrado com sucesso"
    E o veículo deve aparecer na lista de veículos

  Cenário: Editar informações de um veículo
    Dado que existe um veículo "AQ 942"
    E estou logado como administrador
    E estou na página de veículos
    Quando eu clico em "Editar" no veículo "AQ 942"
    E altero a capacidade para "35"
    E altero o ano para "2023"
    E clico no botão "Atualizar"
    Então devo ver a mensagem "Veículo atualizado com sucesso"
    E as informações atualizadas devem aparecer na lista

  Cenário: Excluir um veículo
    Dado que existe um veículo "AQ 942" sem viagens ativas
    E estou logado como administrador
    E estou na página de veículos
    Quando eu clico em "Excluir" no veículo "AQ 942"
    E confirmo a exclusão
    Então devo ver a mensagem "Veículo excluído com sucesso"
    E o veículo não deve mais aparecer na lista

  Cenário: Buscar veículo por modelo
    Dado que existem veículos "Volvo B290R" e "Mercedes Sprinter"
    E estou logado como administrador
    E estou na página de veículos
    Quando eu digito "Volvo" no campo de busca
    E clico no botão "Buscar"
    Então devo ver apenas os veículos Volvo
    E não devo ver os veículos Mercedes

  Cenário: Verificar disponibilidade de veículo
    Dado que existe um veículo "AQ 942"
    E existe uma viagem ativa usando este veículo
    E estou logado como administrador
    E estou na página de veículos
    Então devo ver que o veículo está "Em uso"
    E não deve estar disponível para novas viagens
