# Sistema de Cadastro de Pessoas (Laravel + Filament)

Este é um projeto simples e funcional de um painel administrativo para cadastro e listagem de pessoas, desenvolvido utilizando o ecossistema Laravel com o framework administrativo **Filament PHP (v3)** e banco de dados **MariaDB**.

O ambiente de desenvolvimento local foi estruturado utilizando o **Laravel Sail** (Docker).

---

## 🚀 Funcionalidades

- **Autenticação:** Tela de login segura para a área administrativa.
- **Painel de Controle (Dashboard):** Tela inicial com widget de estatísticas em tempo real (Total de cadastros e cadastros realizados no dia).
- **CRUD de Pessoas:** Gerenciamento completo (Listar, Buscar, Criar, Editar) com os seguintes campos:
  - Nome Completo
  - Endereço
  - CPF
  - Telefone para Contato
- **Internacionalização:** Sistema totalmente traduzido para o Português do Brasil (`pt_BR`).
- **Segurança:** Remoção estrutural de permissões/botões de exclusão de registros para integridade dos dados.

---

## 🛠️ Tecnologias Utilizadas

- **PHP 8.2+**
- **Laravel**
- **Filament PHP v3** (Painel Administrativo)
- **Livewire & Tailwind CSS** (Nativo do Filament)
- **MariaDB / MySQL**
- **Docker & Laravel Sail** (Ambiente local)
- **phpMyAdmin** (Interface do banco de dados local na porta `8080`)

---

