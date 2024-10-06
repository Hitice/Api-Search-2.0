import axios from 'axios';

// resources/js/app.js

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

            axios.post(uploadForm.action, formData)
                .then(response => {
                    // Manipular a resposta do servidor
                    console.log('Upload realizado com sucesso:', response.data);
                    // Aqui você pode redirecionar ou atualizar a página conforme necessário
                })
                .catch(error => {
                    console.error('Erro no upload:', error);
                    // Exibir mensagem de erro se necessário
                })
                .finally(() => {
                    // Esconder a barra de loading e reativar o botão
                    loading.style.display = 'none';
                    uploadButton.disabled = false;
                });
        });
    }
});
