# Desafio Interesses iDent

## Vaga Fullstack Developer Trainee

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
| 7 | Cirurgia e Traumatologia Buco-maxilo-facial | CTBMF | 2018-04-02 09:00:00

### Tabela: interest_suggestion

Utilizada para armazenar a lista de sugestões dos usuários

| ID          | userID                      | name | created |
| --- | --- | --- | --- |
| Primary Key | ID do usuário que fez a sugestão (FK: user.ID) | Nome do interesse sugerido pelo usuário | Quando o interesse  foi sugerido
| 20 | 109124 | Trauma panfacial | 2018-04-02 09:00:00

### Tabela: interest_user

Utilizada para armazenar os interesses que o usuário segue. Tabela relacional com interest ou interest_suggestion dependendo da flag interestIsSuggestion

| ID          | userID                      | interestID | interestIsSuggestion | created |
| --- | --- | --- | --- | --- |
| Primary Key | ID do usuário que segue um interesse | ID do interesse ou da sugestão de interesse (FK: interest.ID ou interest_suggestion.ID) | Flag que indica se o interesse é sugesto ou não. Se 1 então interestID => interest_suggestion.ID se 0 então interestID => interest.ID | Quando o interesse foi seguido | 
| 1 | 109124 | 7 | 0 | 2018-04-02 09:00:00 | 
| 1 | 109124 | 20 | 1 | 2018-04-02 09:00:00 | 

## Desafio - Corrigir erros de digitação em massa

Temos que criar um sistema e interface para tratamento humano dessas sugestões. A ideia é que um operador possa acessar o seu sistema e ver a lista de sugestões inputadas pelos usuários. Nesta mesma tela ele poderá redigitar o interesse com um autocomplete em cima dos oficiais para remapear um interesse sugestão para oficial. Isso facilita a correção de erros de digitação.

#### Requisitos

##### Tela: Gerenciador de interesses
.* Lista sugestões dos usuários: Limite de 30 sugestões com autoload por rolagem
.* Cada linha deve conter seu campo de busca para remapeamento de interesses
.* Ao começar a digitar abre autocomplete com interesses oficiais para remapeamento
.* O operador poderá selecionar um interesse oficial para remapear
.* Interface responsiva

##### Ação de remapear
.* Ao remapear o sistema deve editar a linha relacional da interest_user setando o interestIsSuggestion como 0 e o interestID como o ID do interesse oficial
.* Além disso deve apagar a sugestão do banco após o remapeamento
.* Plus (desafio extra opcional)! Se até aqui você se deu bem e quer ir além, pode ver uma forma de remapear casos identicos automaticamente. Ex: Dois usuários sugeriram trauma panfacial e o operador remapeou um deles para trauma, desta forma ambos seriam remapeados para dar mais agilidade para o operador.

#### Sugestão de Wireframe

Essa sugestão é apenas para melhor compreensão do desafio. Não é necessário segui-lo, você pode usar suas noções de UX para propor soluções melhores ou ainda mais rápidas de fazer.

![alt text](https://lh3.googleusercontent.com/-jamI44AQ5Rk/WqLpx_Lv-qI/AAAAAAAADJI/CePylxE7qbYHbsLTd_Auu9SPpcJD65ppACK8BGAs/s512/2018-03-09.png "Sugestão Wireframe")

## Regras a instruções

#### Acesso ao banco de dados

Já tem um banco de dados criado para facilitar o setup.

host: isl-instance-db-dev.cnqjbbch9s0a.us-east-1.rds.amazonaws.com

user: Enviado no convite do desafio

pass: Enviado no convite do desafio

database: ident_[seu nome]




