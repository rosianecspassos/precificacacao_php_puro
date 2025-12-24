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
            const novoCusto = document.createElement("div");

            novoCusto.classList.add("mb-3", "campo-custo");
            novoCusto.innerHTML = `
                <label>Custos</label><br>
                <input type="number" name="custos[]" min="0" step="0.001" value="0"><br>
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerCampo(this)">Remover</button>
                <hr class="my-3">
            `;

            container.appendChild(novoCusto);
        }

        function adicionarCampoTaxa() {
            const container = document.getElementById("taxas-container");
            const novaTaxa = document.createElement("div");

            novaTaxa.classList.add("mb-3", "campo-taxa");
            novaTaxa.innerHTML = `
                <label>Taxas</label><br>
                <input type="number" name="taxas[]" min="0" step="0.001" value="0"><br>
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerCampo(this)">Remover</button>
                <hr class="my-3">
            `;

            container.appendChild(novaTaxa);
        }

        function removerCampo(button) {
            const item = button.closest('.mb-3');
            if (item) item.remove();
        }
    </script>
</head>

<body>
<div class="container-fluid">
    <div class="container mt-5 text-center">

        <h1 class="mt-3" style="font-size:18px;">Precificação</h1>

        <?php
        $nome_prod = $_POST['nome_prod'] ?? '';
        $custos = 0;
        $taxas = 0;
        $qtde_prod = $_POST['qtde_prod'] ?? 1;
        $lucro_desejado = $_POST['lucro_desejado'] ?? 0;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $custos = is_array($_POST['custos'] ?? null) ? array_sum($_POST['custos']) : 0;
            $taxas  = is_array($_POST['taxas'] ?? null) ? array_sum($_POST['taxas']) : 0;
        }
        ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

            <label>Nome do produto</label><br>
            <input type="text" name="nome_prod" value="<?= htmlspecialchars($nome_prod) ?>"><br><br>

            <!-- CUSTOS -->
            <div id="custos-container-base">
                <?php foreach (is_array($_POST['custos'] ?? null) ? $_POST['custos'] : [0] as $index => $custo): ?>
                    <div class="mb-3 campo-custo">
                        <label>Custos</label><br>
                        <input type="number" name="custos[]" min="0" step="0.001" value="<?= $custo ?>"><br>
                        <?php if ($index > 0): ?>
                            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerCampo(this)">Remover</button>
                        <?php endif; ?>
                        <hr class="my-3">
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="btn btn-secondary btn-sm mb-3" onclick="adicionarCampoCusto()">Adicionar Custo</button>
            <div id="custos-container"></div>

            <!-- TAXAS -->
            <div id="taxas-container-base">
                <?php foreach (is_array($_POST['taxas'] ?? null) ? $_POST['taxas'] : [0] as $index => $taxa): ?>
                    <div class="mb-3 campo-taxa">
                        <label>Taxas</label><br>
                        <input type="number" name="taxas[]" min="0" step="0.001" value="<?= $taxa ?>"><br>
                        <?php if ($index > 0): ?>
                            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerCampo(this)">Remover</button>
                        <?php endif; ?>
                        <hr class="my-3">
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="btn btn-secondary btn-sm mb-3" onclick="adicionarCampoTaxa()">Adicionar Taxa</button>
            <div id="taxas-container"></div>

            <label>Quantidade de produtos</label><br>
            <input type="number" name="qtde_prod" min="1" value="<?= $qtde_prod ?>"><br>

            <label>Margem de lucro (%)</label><br>
            <input type="number" name="lucro_desejado" min="0" step="0.001" value="<?= $lucro_desejado ?>"><br>

            <input type="submit" class="btn btn-primary mt-3 mb-4" value="Calcular">
        </form>
    </div>

    <!-- RESULTADO -->
    <div class="container text-center p-5">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $taxa_decimal = $taxas / 100;
            $lucro_decimal = $lucro_desejado / 100;
            $denominador = 1 - ($taxa_decimal + $lucro_decimal);

            $preco_venda = ($denominador > 0) ? $custos / $denominador : 0;
            $preco_unitario = ($qtde_prod > 0) ? $preco_venda / $qtde_prod : 0;

            echo "<h3>Resultado da Precificação</h3>";
            echo "Produto/Serviço: " . htmlspecialchars($nome_prod) . "<br>";
            echo "Custo Total: R$ " . number_format($custos, 2, ',', '.') . "<br>";
            echo "Taxas Totais: " . number_format($taxas, 2, ',', '.') . "%<br>";
            echo "Quantidade: $qtde_prod <br>";
            echo "Lucro Desejado: " . number_format($lucro_desejado, 2, ',', '.') . "%<br>";
            echo "<strong>Preço de Venda: R$ " . number_format($preco_venda, 2, ',', '.') . "</strong><br>";
            echo "<strong>Preço Unitário: R$ " . number_format($preco_unitario, 2, ',', '.') . "</strong><br>";
        } else {
            echo "<h3>Preencha o formulário para calcular.</h3>";
        }
        ?>
    </div>
</div>

<footer class="bg-light text-center fixed-bottom p-2">
    © 2025 Rosiane Cristina Souza dos Passos - Todos os direitos reservados.
</footer>

</body>
</html>
