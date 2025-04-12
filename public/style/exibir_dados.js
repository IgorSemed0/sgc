$(document).ready(function () {
    var rowsPerPage = 10; // Número de linhas por página
    var rows = $("#userTable tbody tr"); // Seleciona todas as linhas da tabela
    var totalRows = rows.length; // Total de linhas
    var numPages = Math.ceil(totalRows / rowsPerPage); // Calcula o número total de páginas

    function showPage(page) {
        rows.hide(); // Esconde todas as linhas
        var start = (page - 1) * rowsPerPage; // Calcula a linha inicial
        var end = start + rowsPerPage; // Calcula a linha final
        rows.slice(start, end).show(); // Exibe as linhas da página atual
    }

    function createPagination() {
        var pagination = $("#pagination");
        pagination.empty(); // Limpa a paginação existente

        for (var i = 1; i <= numPages; i++) {
            var pageItem = $("<li class='page-item'><a class='page-link' href='#'>" + i + "</a></li>");
            pageItem.click(function (e) {
                e.preventDefault(); // Evita o comportamento padrão de navegação
                var pageNum = parseInt($(this).text()); // Obtém o número da página clicada
                showPage(pageNum); // Exibe as linhas da página clicada
                updateActivePage(pageNum); // Atualiza a página ativa
            });
            pagination.append(pageItem); // Adiciona o item de página na lista
        }
    }

    function updateActivePage(pageNum) {
        $("#pagination li").removeClass("active"); // Remove a classe "active" de todas as páginas
        $("#pagination li:nth-child(" + pageNum + ")").addClass("active"); // Adiciona a classe "active" à página clicada
    }

    if (totalRows > rowsPerPage) {
        showPage(1); // Exibe a primeira página por padrão
        createPagination(); // Cria a paginação
        updateActivePage(1); // Marca a primeira página como ativa
    }
});
