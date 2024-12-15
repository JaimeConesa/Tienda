// Seleccionar el formulario
const form = document.getElementById('LoginForm');

// Escuchar el evento submit
form.addEventListener('submit', async (event) => {
    // Prevenir el envío estándar del formulario
    event.preventDefault();

    // Capturar los datos del formulario
    const formData = new FormData(form);
    const data = {
        usuario: formData.get('usuario'),
        contraseña: formData.get('contraseña')
    };

    // Enviar los datos a la API RESTful
    try {
        const response = await fetch('Tienda/php/procesar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            const result = await response.json();
            console.log('Inició sesión correctamente:', result);

            // Guardar el token y la información de la tienda en el localStorage
            if (result.token && result.tienda) {
                localStorage.setItem('token', result.token);
                localStorage.setItem('tienda', JSON.stringify(result.tienda));

                // Redirigir al Dashboard
                alert('Inicio de sesión exitoso. Redirigiendo al Dashboard...');
                window.location.href = 'dashboard.html';
            } else {
                alert('Error: no se recibió un token o información de la tienda.');
            }
        } else {
            console.error('Error al iniciar sesión:', response.statusText);
            alert('Credenciales incorrectas. Intente nuevamente.');
        }
    } catch (error) {
        console.error('Error de conexión:', error);
        alert('Error de conexión. Intente más tarde.');
    }
});
