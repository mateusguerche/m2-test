<h1>Projeto</h1>
<div align="justify">
<p>
Para começar certifique-se que o Docker está instalado em seu sistema e em seguida, clone este repositório.
</p>    
    
<pre class="notranslate">
<code>
git clone https://github.com/mateusguerche/m2-test.git
</code>
</pre>
    
<p>
Logo após, navegue em seu terminal até o diretório que você clonou e execute os dois grupos de comandos no mesmo terminal:
</p> 
    
<p>
-Primeiro Grupo:
</p>  
<pre class="notranslate">
<code>
cp docker-compose-dev.yml docker-compose.yml && \ 
cp .env.example .env && \ 
docker-compose up -d && \ 
docker exec -it m2-php bash 
</code>
</pre>
    
<p>
-Segundo Grupo:   
</p>  
<pre class="notranslate">
<code>
cd /var/www/html && \ 
composer install && \ 
php artisan key:generate && \ 
php artisan storage:link && \ 
chmod -R 777 storage/ && \
php artisan migrate:fresh --seed && \ 
php artisan cache:clear && \ 
php artisan route:clear
</code>
</pre>  
    
<p>
Com esses comandos o ngninx, mysql e php foram iniciados e agora já será possível utilizar o projeto desenvolvido
</p> 
</div>
</br>

<h1>Insomnia</h1>
<div align="justify">
<p>
Foi utilizado o Insomnia para o desenvolvimento da API. Pode-se encontrar o arquivo “insomnia.json” para importação na pasta “/insomnia/”.
</p>
<p>
Este é o link para o download do aplicativo Insomnia:
</p>
<p>
Link: https://insomnia.rest/download
</p>
</br>
<p>
 -Esta foto demonstra onde o arquivo “insomnia.json” está localizado
</p>
<p>
 <img src="https://user-images.githubusercontent.com/73080168/195162491-662e5f44-fe38-4a32-b3dd-79c6cb6e77ea.png" style="max-width: 100%;">
</p>

</br>
<p>
 -Esta foto demonstra que ao lado esquerdo se encontra todas as rotas e ao lado direto os retornos.
</p>
<p>
 <img src="https://user-images.githubusercontent.com/73080168/195174507-f1ecd489-d997-406d-871f-c6bbb18e9410.png" style="max-width: 100%;">
</p>

</br>
<p>
 -Esta foto demonstra nos docs do insomnia que contém os detalhes de cada rota.
</p>
<p>
 <img src="https://user-images.githubusercontent.com/73080168/195174720-f6850c36-9139-43ba-8e21-87e38400f94e.png" style="max-width: 100%;">
</p>
</div>
</br>

<h1>Diagrama</h1>
<div align="justify">
<p>
Foi realizado um diagrama do projeto.
</p>
<p>
<img src="https://user-images.githubusercontent.com/73080168/195175339-e3a27cbf-6770-42b8-a39c-20c97080b80d.png" style="max-width: 100%;">
</p>
</div>
</br>

<h1>Rotas e suas funcionalidades</h1>
<div align="justify">

<div>
<h3>Tabela city_groups</h3>
<p>
Rota GET: http://localhost:8080/api/v1/city-groups
</br>
-Exibe todos os Grupos de Cidades.
</p> 
</br>

<p>
Rota POST: http://localhost:8080/api/v1/city-groups 
</br>
-Cadastra um novo Grupo de Cidades.
</br>
Parâmetros:
<li>
"name"(string) required|min:2|max:255
</li>
</p> 
</br>

<p>
Rota GET: http://localhost:8080/api/v1/city-groups/{id} 
</br>
-Exibe um Grupo de Cidades.   
</p>
</br>

<p>
Rota PUT: http://localhost:8080/api/v1/city-groups/{id} 
</br>
-Edita um Grupo de Cidades.
</br>
Parâmetros:
<li>
"name"(string) min:2|max:255
</li>
</p>
</br>

<p>
Rota DELETE: http://localhost:8080/api/v1/city-groups/{id}/destroy
</br>
-Exclui um Grupo de Cidades.
</p> 
</div>
</br>

<div>
<h3>Tabela cities</h3>
<p>
Rota GET: http://localhost:8080/api/v1/cities
</br>
-Exibe todas as Cidades.
</p> 
</br>

<p>
Rota POST: http://localhost:8080/api/v1/cities
</br>
-Cadastra uma Cidade.
Parâmetros:
<li>
"name"(string) required|min:2|max:255
</li>
<li>
"state"(string) required|['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MS', 'MT', 'MG',
'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO']
</li>
<li>
"city_group_id"(int) required
</li>
</p>
</br> 

<p>
Rota GET: http://localhost:8080/api/v1/cities/{id}
</br>
-Exibe uma Cidade. 
</p> 
</br>

<p>
Rota PUT: http://localhost:8080/api/v1/cities/{id}
</br>
-Edita uma Cidade.
</br>
Parâmetros:
<li>
"name"(string) min:2|max:255
</li>
<li>
"state"(string) ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MS', 'MT', 'MG', 'PA','PB',
'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO']
</li>
<li>
"city_group_id"(int)
</li>
</p>
</br> 

<p>
Rota DELETE: http://localhost:8080/api/v1/cities/{id}/destroy
</br>
-Exclui uma Cidade.
</p> 
</div>
</br>

<div>
<h3>Tabela products</h3>
<p>
Rota GET: http://localhost:8080/api/v1/products
</br>
-Exibe todos os Produtos.
</p>
</br>

<p>
Rota POST: http://localhost:8080/api/v1/products
</br>
-Cadastra um novo Produto.
Parâmetros:
<li>
"name"(string) required|min:2|max:255
</li>
<li>
"value"(numeric) required
</li>
</p>
</br>

<p>
Rota GET: http://localhost:8080/api/v1/products/{id}
</br>
-Exibe um Produto.
</p>
</br>
 
<p>
Rota PUT: http://localhost:8080/api/v1/products/{id}
</br>
-Edita um Produto.
Parâmetros:
<li>
"name"(string) min:2|max:255
</li>
<li>
"value"(numeric)
</li>
</p>
</br>

<p>
Rota DELETE: http://localhost:8080/api/v1/products/{id}/destroy
</br>
-Exclui um Produto.
</p> 
</div>
</br>

<div>
<h3>Tabela discounts</h3>
<p>
Rota GET: http://localhost:8080/api/v1/discounts
</br>
-Exibe todos os Descontos.
</p> 
</br>

<p>
Rota POST: http://localhost:8080/api/v1/discounts
</br>
-Cadastra um novo Desconto.
Parâmetros:
<li>
"amount"(numeric) required
</li>
<li>
"type"(string) required|['value', 'percentage']
</li>
</p>
</br>

<p>
Rota GET: http://localhost:8080/api/v1/discounts/{id}
</br>
-Exibe um Desconto.
</p>
</br>
 
<p>
Rota PUT: http://localhost:8080/api/v1/discounts/{id}
</br>
-Edita um Desconto.
Parâmetros:
<li>
"amount"(numeric)
</li>
<li>
"type"(string) ['value', 'percentage']
</li>
</p>
</br>

<p>
Rota DELETE: http://localhost:8080/api/v1/discounts/{id}/destroy
</br>
-Exclui um Desconto.
</p> 
</div>
</br>

<div>
<h3>Tabela campaigns</h3>
<p>
Rota GET: http://localhost:8080/api/v1/campaigns
</br>
-Exibe todas as Campanhas.
</p> 
</br>

<p>
Rota POST: http://localhost:8080/api/v1/campaigns
</br>
-Cadastra um nova Campanha.
</br>
Parâmetros:
<li>
"name"(string) required|min:2|max:255
</li>
<li>
"city_group_id"(int) required
</li>
<li>
"discount_id"(int) nullable
</li>
<li>
"campaign_products[].product_id"(integer) required
</li>
</p>
</br>

<p>
Rota GET: http://localhost:8080/api/v1/campaigns/{id}
</br>
-Exibe uma Campanha.
</p> 
</br>
 
<p>
 Rota PUT: http://localhost:8080/api/v1/campaigns/{id}
</br>
-Edita uma Campanha.
</br>
Parâmetros:
<li>
"name"(string) min:2|max:255
</li>
<li>
"city_group_id"(int)
</li>
<li>
"discount_id"(int) nullable
</li>
<li>
"status"(bool) required
</li>
<li>
"campaign_products[].product_id"(integer) required
</li>
</p>
</br>

<p>
Rota DELETE: http://localhost:8080/api/v1/campaigns/{id}/destroy
</br>
-Exclui uma Campanha.
</p> 
</div>
</div>
