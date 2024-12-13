// Seleccionar el formulario
const form = document.getElementById('productForm');
// Escuchar el evento submit
form.addEventListener('submit', async (event) => {
    // Prevenir el envío estándar del formulario
    event.preventDefault();
    // Capturar los datos del formulario
    const formData = new FormData(form);
    const data = {
        usuario: formData.get('usuario'),
        contraseña:formData.get('contraseña')
    };
    // Enviar los datos a la API RESTful
    try {
        const response = await fetch('../../php/procesar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        if (response.ok) {
            const result = await response.json();
            console.log('Inició sesión correctamente:', result);
            alert('Inició sesión correctamente:');
        } else {
            console.error('Error al iniciar sesión:', response.statusText);
        }
    } catch (error) {
        console.error('Error de conexión:', error);
    }
});