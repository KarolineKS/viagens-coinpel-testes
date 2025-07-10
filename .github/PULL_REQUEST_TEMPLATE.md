<!-- OBRIGADO POR CONTRIBUIR! -->

### Tipo de Mudança

<!-- Marque a(s) caixa(s) que se aplica(m) -->

-   [ ] Correção de bug
-   [x] Nova feature
-   [ ] Refatoração
-   [ ] Chore (configuração, dependências, etc.)

### O que este PR faz?

<!-- Descreva de forma clara e concisa o objetivo principal das suas alterações. -->

Este PR implementa o sistema de autenticação administrativo com funcionalidade de mudança obrigatória de senha no primeiro login.

### Principais Mudanças

<!-- Liste as alterações mais importantes em formato de tópicos. -->

-   Adicionar controller para mudança de senha (ChangePasswordController)
-   Implementar validação de senha no lado cliente
-   Criar fluxo de primeiro login com mudança obrigatória de senha
-   Adicionar migration para campo first_login na tabela users
-   Implementar validação de requisições (ChangePasswordRequest)
-   Criar interface responsiva para mudança de senha

### Como Testar Manualmente

<!-- Forneça um passo a passo para que o revisor possa testar suas alterações. -->

1. Acessar a página de login
2. Fazer login com um usuário que tem first_login = true
3. Verificar se o modal de mudança de senha aparece obrigatoriamente
4. Testar validação de senha (mínimo 8 caracteres)
5. Confirmar que as senhas coincidem
6. Verificar se a senha é alterada com sucesso

### Checklist de Qualidade

-   [x] Eu testei minhas alterações localmente e elas funcionam como esperado.
-   [x] O código segue o guia de estilo do projeto.
-   [x] Não há `console.log` ou `dd()` esquecidos no código.
-   [x] As migrations (se houver) foram testadas e funcionam.
