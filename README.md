# Precifique Fácil
## Precificação de produtos 
#### Disponível em:
https://precifiquefacil.infinityfreeapp.com
### 🛠 Tecnologias utilizadas
 - PHP
 - HTML
 - CSS
 - JavaScript
 - Bootstrap
## Descrição 
O sistema web cálculo de precificação foi desenvolvido para auxiliar empreendedores e pequenos negócios a definirem corretamente o **preço de venda** de seus produtos ou serviços, garantindo lucro e evitando prejuízos.

### 🧠 Como funciona

1. O usuário acessa o formulário de cálculo através da URL.
2. Os dados de custo, despesas, impostos e margem de lucro são enviados via requisição **POST**.
3. O sistema valida todas as informações recebidas.
4. O cálculo do preço de venda é realizado no backend.
5. O resultado final é exibido ao usuário de forma clara e objetiva.

#### 📊 Itens considerados no cálculo
- Custos fixos  
- Custos variáveis  
- Percentual de impostos  
- Margem de lucro desejada

#### Fórmulas 

- Custo Total = Σ custos
- Taxa Total (%) = Σ taxas

- Taxa Decimal = Taxa Total / 100
- Lucro Decimal = Lucro / 100

- Denominador = 1 − Taxa Decimal − Lucro Decimal

- Valor de Venda = Custo Total / Denominador

- Preço Unitário = Valor de Venda / Quantidade

### 🧩 Diagramas de Arquitetura 

```text
┌───────────────┐
│     Usuário   │
└───────┬───────┘
        │
        │ Preenche formulário de cálculo
        ▼
┌────────────────────────┐
│   URL                  │
│ Formulário de Cálculo  │
└─────────┬──────────────┘
          │ POST /calcular
          ▼
┌────────────────────────┐
│   index.php            │
│ - Validação dos dados  │
│ - Regras de negócio    │
│ - Cálculo do preço     │
| ---------------------  │
│  Camada de Lógica      │
│ (Fórmulas de cálculo)  │
│ - Retorno para a View  │
│ - Resultado do cálculo │
└────────────────────────┘


