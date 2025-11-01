
    const telefoneInput = document.getElementById('telefone');

    telefoneInput.addEventListener('input', function () {
      let telefone = telefoneInput.value.replace(/\D/g, '');

      if (telefone.length > 11) {
        telefone = telefone.slice(0, 11);
      }

      if (telefone.length <= 10) {
        telefone = telefone.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
      } else {
        telefone = telefone.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
      }

      telefoneInput.value = telefone;
    });

       function toggleCollapse(header) {
            const container = header.parentElement;
            const content = header.nextElementSibling;
            
            header.classList.toggle('expanded');
            content.classList.toggle('expanded');
        }
