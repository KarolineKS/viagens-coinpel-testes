Funcionalidade: Gerenciamento de usuários
  Como um administrador do sistema
  Eu quero gerenciar usuários
  Para controlar o acesso ao sistema

  Cenário: Cadastrar um novo usuário
    Dado que estou logado como administrador
    E estou na página de usuários
    Quando eu clico no botão "Novo Usuário"
    E preencho o nome "Maria Silva"
    E preencho o email "maria@example.com"
    E preencho a senha "senha123"
    E confirmo a senha "senha123"
    E marco a opção "Primeiro login"
    E clico no botão "Salvar"
    Então devo ver a mensagem "Usuário cadastrado com sucesso"
    E o usuário deve aparecer na lista de usuários

  Cenário: Bloquear um usuário
    Dado que existe um usuário "Maria Silva"
    E estou logado como administrador
    E estou na página de usuários
    Quando eu clico em "Bloquear" no usuário "Maria Silva"
    E confirmo o bloqueio
    Então devo ver a mensagem "Usuário bloqueado com sucesso"
    E o usuário deve aparecer como bloqueado na lista

  Cenário: Desbloquear um usuário
    Dado que existe um usuário "Maria Silva" bloqueado
    E estou logado como administrador
    E estou na página de usuários
    Quando eu clico em "Desbloquear" no usuário "Maria Silva"
    E confirmo o desbloqueio
    Então devo ver a mensagem "Usuário desbloqueado com sucesso"
    E o usuário deve aparecer como ativo na lista

  Cenário: Alterar senha de usuário
    Dado que existe um usuário "Maria Silva"
    E estou logado como administrador
    E estou na página de usuários
    Quando eu clico em "Alterar Senha" no usuário "Maria Silva"
    E preencho a nova senha "nova_senha123"
    E confirmo a nova senha "nova_senha123"
    E clico no botão "Atualizar Senha"
    Então devo ver a mensagem "Senha alterada com sucesso"
    E o usuário deve conseguir fazer login com a nova senha

  Cenário: Buscar usuário por email
    Dado que existem usuários "maria@example.com" e "joao@example.com"
    E estou logado como administrador
    E estou na página de usuários
    Quando eu digito "maria" no campo de busca
    E clico no botão "Buscar"
    Então devo ver apenas o usuário "maria@example.com"
    E não devo ver o usuário "joao@example.com"
