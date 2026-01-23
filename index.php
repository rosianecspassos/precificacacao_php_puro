<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Precificação de produtos e serviços</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        function adicionarCampoCusto() {
            const container = document.getElementById("custos-container");
            const div = document.createElement("div");

            div.classList.add("mb-2");
            div.innerHTML = `
                <input type="number" name="custos[]" class="form-control w-25 mx-auto mb-2" min="0" step="0.001" value="0">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Remover</button>
            `;
            container.appendChild(div);
        }

        function adicionarCampoTaxa() {
            const container = document.getElementById("taxas-container");
            const div = document.createElement("div");

            div.classList.add("mb-2");
            div.innerHTML = `
                <input type="number" name="taxas[]" class="form-control w-25 mx-auto mb-2" min="0" step="0.001" value="0">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Remover</button>
            `;
            container.appendChild(div);
        }
    </script>
</head>

<body>

<div class="container mt-5 position-relative border rounded-3 pt-5 pb-5">

    <!-- TÍTULO SOBRE A BORDA -->
    <div class="position-absolute top-0 start-50 translate-middle bg-white px-3">
        <h1 class="text-primary mb-0" style="font-size:28px;">
            Precificação
        </h1>
    </div>

    <?php
    $nome_prod = $_POST['nome_prod'] ?? '';
    $qtde_prod = $_POST['qtde_prod'] ?? 1;
    $lucro_desejado = $_POST['lucro_desejado'] ?? 0;

    $custos = 0;
    $taxas = 0;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $custos = is_array($_POST['custos'] ?? null) ? array_sum($_POST['custos']) : 0;
        $taxas  = is_array($_POST['taxas'] ?? null) ? array_sum($_POST['taxas']) : 0;
    }
    ?>

    <form method="post">

        <!-- Nome do produto -->
        <div class="mb-4 text-center">
            <label class="form-label">Nome do produto</label>
            <input type="text"
                   name="nome_prod"
                   class="form-control w-50 mx-auto"
                   value="<?= htmlspecialchars($nome_prod) ?>">
        </div>

        <!-- Custos e Taxas -->
        <div class="row text-center">

            <!-- Custos -->
            <div class="col-md-6 mb-4">
                <p class="fw-semibold">Custos</p>

                <?php foreach (is_array($_POST['custos'] ?? null) ? $_POST['custos'] : [0] as $custo): ?>
                    <input type="number"
                           name="custos[]"
                           class="form-control w-25 mx-auto mb-2"
                           min="0" step="0.001"
                           value="<?= $custo ?>">
                <?php endforeach; ?>

                <div id="custos-container"></div>

                <button type="button"
                        class="btn btn-secondary btn-sm mt-2"
                        onclick="adicionarCampoCusto()">
                    + Adicionar Custo
                </button>
            </div>

            <!-- Taxas -->
            <div class="col-md-6 mb-4">
                <p class="fw-semibold">Taxas (%)</p>

                <?php foreach (is_array($_POST['taxas'] ?? null) ? $_POST['taxas'] : [0] as $taxa): ?>
                    <input type="number"
                           name="taxas[]"
                           class="form-control w-25 mx-auto mb-2"
                           min="0" step="0.001"
                           value="<?= $taxa ?>">
                <?php endforeach; ?>

                <div id="taxas-container"></div>

                <button type="button"
                        class="btn btn-secondary btn-sm mt-2"
                        onclick="adicionarCampoTaxa()">
                    + Adicionar Taxa
                </button>
            </div>

        </div>

        <!-- Quantidade e Lucro -->
        <div class="row text-center">

            <div class="col-md-6 mb-4">
                <label class="form-label">Quantidade de produtos</label>
                <input type="number"
                       name="qtde_prod"
                       class="form-control w-25 mx-auto"
                       min="1"
                       value="<?= $qtde_prod ?>">
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">Margem de lucro (%)</label>
                <input type="number"
                       name="lucro_desejado"
                       class="form-control w-25 mx-auto"
                       min="0" step="0.001"
                       value="<?= $lucro_desejado ?>">
            </div>

        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary px-5">
                Calcular
            </button>
        </div>

    </form>

    <!-- Resultado -->
    <div class="text-center mt-5">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $taxa_decimal = $taxas / 100;
            $lucro_decimal = $lucro_desejado / 100;
            $denominador = 1 - ($taxa_decimal + $lucro_decimal);

            $preco_venda = ($denominador > 0) ? $custos / $denominador : 0;
            $preco_unitario = ($qtde_prod > 0) ? $preco_venda / $qtde_prod : 0;

            echo "<h4>Resultado da Precificação</h4>";
            echo "Produto: " . htmlspecialchars($nome_prod) . "<br>";
            echo "Custo Total: R$ " . number_format($custos, 2, ',', '.') . "<br>";
            echo "Taxas Totais: " . number_format($taxas, 2, ',', '.') . "%<br>";
            echo "Lucro Desejado: " . number_format($lucro_desejado, 2, ',', '.') . "%<br><br>";
            echo "<strong>Preço de Venda: R$ " . number_format($preco_venda, 2, ',', '.') . "</strong><br>";
            echo "<strong>Preço Unitário: R$ " . number_format($preco_unitario, 2, ',', '.') . "</strong>";
        }
        ?>
    </div>

</div>

<footer class="bg-light text-center p-3 mt-2 mb-2">
    © 2025 Rosiane Cristina Souza dos Passos - Todos os direitos reservados.
</footer>

</body>
</html>




