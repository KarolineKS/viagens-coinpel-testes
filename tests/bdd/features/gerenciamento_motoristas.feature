Funcionalidade: Gerenciamento de motoristas
  Como um administrador do sistema
  Eu quero gerenciar motoristas
  Para ter controle sobre quem conduz os veículos

  Cenário: Cadastrar um novo motorista
    Dado que estou logado como administrador
    E estou na página de motoristas
    Quando eu clico no botão "Novo Motorista"
    E preencho o nome "João Silva"
    E preencho o CPF "123.456.789-01"
    E preencho o RG "12.345.678-9"
    E preencho o email "joao@example.com"
    E preencho o telefone "(11) 98765-4321"
    E preencho a categoria da CNH "D"
    E preencho o número da CNH "12345678901"
    E preencho a data de validade da CNH "31/12/2025"
    E preencho o endereço completo
    E clico no botão "Salvar"
    Então devo ver a mensagem "Motorista cadastrado com sucesso"
    E o motorista deve aparecer na lista de motoristas

  Cenário: Editar dados de um motorista
    Dado que existe um motorista "João Silva"
    E estou logado como administrador
    E estou na página de motoristas
    Quando eu clico em "Editar" no motorista "João Silva"
    E altero o telefone para "(11) 99999-9999"
    E altero o email para "joao.novo@example.com"
    E clico no botão "Atualizar"
    Então devo ver a mensagem "Motorista atualizado com sucesso"
    E os dados atualizados devem aparecer na lista

  Cenário: Buscar motorista por nome
    Dado que existem motoristas "João Silva" e "Maria Santos"
    E estou logado como administrador
    E estou na página de motoristas
    Quando eu digito "João" no campo de busca
    E clico no botão "Buscar"
    Então devo ver apenas o motorista "João Silva"
    E não devo ver o motorista "Maria Santos"

  Cenário: Verificar CNH vencida
    Dado que existe um motorista com CNH vencida
    E estou logado como administrador
    E estou na página de motoristas
    Então devo ver um alerta indicando CNH vencida
    E o motorista não deve estar disponível para novas viagens
