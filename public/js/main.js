// Core JavaScript for Academy - Growth Partner System Replica
document.addEventListener('DOMContentLoaded', () => {
    console.log('¡Academy Growth Partner System cargado con éxito!');

    // Manejar dinámicamente interacciones asíncronas sencillas
    const postTextArea = document.querySelector('.post-composer textarea');
    const postBtn = document.querySelector('.post-composer button');

    if (postBtn && postTextArea) {
        postBtn.addEventListener('click', () => {
            const content = postTextArea.value.trim();
            if (content === '') {
                alert('¡Por favor escribe algo antes de publicar!');
                return;
            }

            alert('¡Publicación enviada con éxito en modo demostración!');
            postTextArea.value = '';
        });
    }
});
