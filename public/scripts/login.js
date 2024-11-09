const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnLogin-pop');
const iconClose = document.querySelector('.icon-close');

registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', () => {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', () => {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', () => {
    wrapper.classList.remove('active-popup');
});

const login = document.getElementById("login");

login.addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = new FormData(e.target);
    
    const response = await fetch('http://localhost/residencial/?action=login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: form.get("email"), 
            pass: form.get("pass")
        })
    });

    // Comprobar si la respuesta fue exitosa
    if (response.ok) {
        const result = await response.json();
        
        if (!result.state) {
            alert(result.message);
            return;
        }
        
        window.location.href = '../app/view/dashboard.php';
    } else {
        alert("Error en la solicitud. Por favor, intenta de nuevo."); // Mensaje de error si la respuesta no es ok
    }
});
