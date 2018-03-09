# Desafio Interesses iDent - Vaga Fullstack Developer Trainee

Você foi secionado para o desafio para vaga de Trainee Fullstack do iDent. \o/

Esse desafio serve para podermos avaliar melhor seus conhecimentos práticos no nosso stack de desenvolvimento. (PHP, MySQL, jQuery, HTML Responsivo). Não há soluçoes certas nem erradas, ao topar o desafio esse é um espaço para você mostrar até aonde seus conhecimentos vão. As melhores soluções ou com maior potencial serão selecionadas para a vaga.

Boa sorte!

## Cenário

Para todos os usuários no iDent, nós pedimos no momento do cadastro que indiquem 3 ou mais interesses dentro da Odontologia. Esses interesses podem ser técnicas, especialidades, procedimentos, materiais, etc... 

No momento que o usuário preenche seu interesse nós sugerimos uma lista (autocomplete) que é alimentada a partir de uma tabela de intersses oficiais (pré-cadastrados por nós), porém o usuário também pode adicionar um texto livre como interesse gerando uma tabela de sugestes de interesses.

Desta forma conseguimos fazer com que a maioria dos interesses sejam oficiais (gerendo inteligência para o negócio, como por exemplo segmentação de base por interesse ou sugestões de conteúdo), mas não tolimos o usuário de indicar interesses que estão faltando para tratarmos no futuro (sugestões).

## Estrutura de dados

Para facilitar a compreensão do desafio, primeiro estude e tire suas dúvidas sobre a estrutura de dados que é utilizada para gestão de interesses no iDent:

### Tabela: interest

Utilizada para armazenar a lista de interesses oficiais

| ID          | name                      | abbr  | created |
| --- | --- | --- | --- |
| Primary Key | Nome do interesse oficial | Abreviação do interesse oficial | Quando o interesse oficial foi inserido no banco

### Tabela: interest_suggestion

Utilizada para armazenar a lista de sugestões dos usuários

| ID          | userID                      | name | created |
| --- | --- | --- | --- |
| Primary Key | ID do usuário que fez a sugestão (FK: user.ID) | Nome do interesse sugerido pelo usuário | Quando o interesse  foi sugerido



