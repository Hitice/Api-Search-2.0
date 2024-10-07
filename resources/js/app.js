

// Importando o JavaScript do Bootstrap
import 'bootstrap';

import axios from 'axios';

document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const uploadButton = document.getElementById('uploadButton');
    const loading = document.getElementById('loading');

    if (uploadForm) {
        uploadForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão de envio do formulário

            // Exibir a barra de loading
            loading.style.display = 'block';

            // Desativar o botão de upload para evitar múltiplos envios
            uploadButton.disabled = true;

            // Enviar o formulário usando axios
            const formData = new FormData(uploadForm);

            // Adicionar valores das caixas de seleção ao FormData
            const checkboxes = uploadForm.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    formData.append(checkbox.name, checkbox.value);
                }
            });

            axios.post(uploadForm.action, formData)
                .then(response => {
                    console.log('Upload realizado com sucesso:', response.data);
                    // Você pode adicionar lógica adicional aqui, como mostrar uma mensagem de sucesso
                })
                .catch(error => {
                    console.error('Erro no upload:', error);
                    // Você pode adicionar lógica adicional aqui, como mostrar uma mensagem de erro
                })
                .finally(() => {
                    // Esconder a barra de loading e reativar o botão
                    loading.style.display = 'none';
                    uploadButton.disabled = false;
                });
        });
    }
});
