document.addEventListener("DOMContentLoaded", () => {
    const termo = document.getElementById('termoTexto');
    const botaoAceitar = document.getElementById('btnAceitar');
    const checkbox = document.getElementById('terms');

    if (!termo) return; // evita erro se estiver em outra página

    termo.addEventListener('scroll', () => {
        if (termo.scrollTop + termo.clientHeight >= termo.scrollHeight - 10) {
            botaoAceitar.disabled = false;
        }
    });

    botaoAceitar.addEventListener('click', () => {
        checkbox.disabled = false;
        checkbox.checked = true;
        $('#modalTermos').modal('hide');
    });
});