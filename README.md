# Patrimon.io - Sistema de Gestão de Ativos

Projeto desenvolvido no âmbito das disciplinas **TCC I e TCC II**, sob a orientação do professor **Flávio de Assis Vilela** e a supervisão do professor responsável pela disciplina, **Sergio Henrique de Almeida**, ambos docentes do curso de **Tecnologia em Análise e Desenvolvimento de Sistemas**, do **Instituto Federal de Goiás – Câmpus Jataí, Unidade Flamboyant.**

## Configuração do ambiente

Este repositório **não** versiona o arquivo `.env` (ele está no `.gitignore`) para evitar o vazamento de chaves e credenciais.

Para configurar localmente:

1. Copie o arquivo de exemplo:
   - Windows (PowerShell): `Copy-Item .env.example .env`
   - Linux/macOS: `cp .env.example .env`
2. Preencha os valores necessários no `.env` (ex.: credenciais do banco).
3. Gere a chave da aplicação:
   - `php artisan key:generate`