Funcionalidade: Autenticação de usuário
  Como um usuário do sistema
  Eu quero poder fazer login e logout
  Para acessar as funcionalidades do sistema

  Cenário: Login com credenciais válidas
    Dado que estou na página de login
    Quando eu preencho o email "admin@coinpel.com"
    E preencho a senha "password"
    E clico no botão "Entrar"
    Então devo ser redirecionado para o dashboard
    E devo ver a mensagem de boas-vindas

  Cenário: Login com credenciais inválidas
    Dado que estou na página de login
    Quando eu preencho o email "usuario@inexistente.com"
    E preencho a senha "senha_errada"
    E clico no botão "Entrar"
    Então devo permanecer na página de login
    E devo ver uma mensagem de erro

  Cenário: Logout do sistema
    Dado que estou logado no sistema
    Quando eu clico no botão "Logout"
    Então devo ser redirecionado para a página de login
    E devo ver a mensagem "Você foi deslogado com sucesso"

  Cenário: Usuário bloqueado não pode fazer login
    Dado que existe um usuário bloqueado com email "bloqueado@coinpel.com"
    Quando eu tento fazer login com email "bloqueado@coinpel.com"
    E senha "password"
    Então devo ver uma mensagem de erro
    E não devo conseguir acessar o sistema
