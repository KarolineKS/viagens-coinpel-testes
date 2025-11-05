# 📋 Guia de Execução de Testes

## 🚀 Comandos para Executar Testes

### **Executar TODOS os testes:**

```bash
php artisan test
```

_Executa tanto testes Unit quanto Feature_

### **Executar apenas testes Unit:**

```bash
php artisan test --testsuite=Unit
```

### **Executar apenas testes Feature:**

```bash
php artisan test --testsuite=Feature
```

## 🏷️ Executar Testes por Grupos

### **Testes Unitários por Grupo:**

#### **Todos os modelos:**

```bash
php artisan test --group=models
```

#### **Apenas modelo User:**

```bash
php artisan test --group=user
```

#### **Apenas modelo Vehicle:**

```bash
php artisan test --group=vehicle
```

#### **Apenas modelo Driver:**

```bash
php artisan test --group=driver
```

#### **Apenas modelo Trip:**

```bash
php artisan test --group=trip
```

### **Testes Feature por Grupo:**

#### **Todos os controllers:**

```bash
php artisan test --group=controllers
```

#### **Apenas autenticação:**

```bash
php artisan test --group=auth
```

#### **Apenas CRUD de motoristas:**

```bash
php artisan test --group=drivers
```

#### **Apenas CRUD de viagens:**

```bash
php artisan test --group=trips
```

#### **Apenas CRUD de veículos:**

```bash
php artisan test --group=vehicles
```

## 📊 Grupos Disponíveis

### **Testes Unitários:**

-   `@group unit` - Todos os testes unitários
-   `@group models` - Todos os modelos
-   `@group user` - Modelo User
-   `@group vehicle` - Modelo Vehicle
-   `@group driver` - Modelo Driver
-   `@group trip` - Modelo Trip

### **Testes Feature:**

-   `@group feature` - Todos os testes feature
-   `@group controllers` - Todos os controllers
-   `@group auth` - Autenticação
-   `@group drivers` - CRUD de motoristas
-   `@group trips` - CRUD de viagens
-   `@group vehicles` - CRUD de veículos

## 🎯 Exemplos Práticos

### **Testar apenas autenticação:**

```bash
php artisan test --group=auth
```

### **Testar apenas modelos:**

```bash
php artisan test --group=models
```

### **Testar apenas um arquivo específico:**

```bash
php artisan test tests/Unit/UserTest.php
```

### **Testar com mais detalhes:**

```bash
php artisan test --verbose
```

## 🎯 Testes BDD (Behavior Driven Development)

### **Executar testes BDD com Playwright:**

```bash
npm run test:bdd
```

### **Executar testes BDD com interface visual:**

```bash
npm run test:bdd:ui
```

### **Executar testes BDD com navegador visível:**

```bash
npm run test:bdd:headed
```

### **Executar todos os testes E2E (incluindo BDD):**

```bash
npm run test:e2e
```

### **Ver relatório dos testes BDD:**

```bash
npm run test:e2e:report
```

### **Executar testes BDD com Behat (alternativo):**

```bash
./run-bdd-tests.sh
```

### **Executar teste específico com Behat:**

```bash
vendor/bin/behat features/autenticacao.feature
```

### **Executar testes BDD com Laravel Dusk:**

```bash
php artisan dusk
```

### **Executar um teste específico:**

```bash
php artisan dusk tests/Browser/SistemaGerenciamentoViagensTest.php
```

### **Executar um cenário específico:**

```bash
php artisan dusk --filter=test_usuario_faz_login_no_sistema
```

### **Executar com interface gráfica:**

```bash
php artisan dusk --browser=chrome
```

### **Executar em modo headless:**

```bash
php artisan dusk --headless
```

## 🎭 Testes E2E com Playwright

### **Executar todos os testes E2E:**

```bash
npm run test:e2e
```

### **Executar testes com interface gráfica:**

```bash
npm run test:e2e:ui
```

### **Executar testes com navegador visível:**

```bash
npm run test:e2e:headed
```

### **Executar testes em modo debug:**

```bash
npm run test:e2e:debug
```

### **Visualizar relatório de testes:**

```bash
npm run test:e2e:report
```

### **Instalar navegadores do Playwright:**

```bash
npm run test:e2e:install
```

## 📈 Status dos Testes

### **Testes Unitários e Feature:**

-   ✅ **88 testes passando**
-   ⚠️ **6 testes pulados** (funcionalidades não implementadas)
-   ❌ **0 testes falhando**

### **Testes BDD (Behavior Driven Development):**

-   ✅ **25+ cenários implementados** com Behat
-   🎯 **Cobertura completa** dos fluxos principais
-   🔄 **Testes de ponta a ponta** (E2E)
-   📝 **Linguagem natural** (Gherkin)
-   🧪 **Documentação executável**

### **Testes BDD com Laravel Dusk:**

-   ✅ **10 cenários implementados**
-   🎯 **Cobertura completa** dos fluxos principais
-   🔄 **Testes de ponta a ponta** (E2E)

### **Testes E2E com Playwright:**

-   ✅ **40+ cenários implementados**
-   🎭 **Múltiplos navegadores** (Chrome, Firefox, Safari)
-   📱 **Testes responsivos** (mobile e desktop)
-   🔍 **Debugging avançado** com traces e vídeos

## 🔧 Testes Pulados (Skipped)

Os testes pulados são para funcionalidades que não estão implementadas na aplicação:

1. **Intervention Image** - Biblioteca não instalada
2. **Mocking complexo** - Testes de exceções
3. **Views não implementadas** - trips.show
4. **Funcionalidades não implementadas** - Registro de usuário
5. **Comportamentos que variam** - Validações específicas
