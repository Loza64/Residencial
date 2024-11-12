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


document.getElementById("login").addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = new FormData(e.target);
    const response = await fetch('http://localhost/residencial/?action=login', {
        headers: { 'Content-Type': 'application/json' },
        method: 'POST',
        body: JSON.stringify({
            email: form.get("email"),
            pass: form.get("pass")
        })
    });
    const result = await response.json();
    if (response.status === 200) {
        alert(result.message);
        window.location.href = 'http://localhost/residencial/?action=redirect';
    } else {
        alert(JSON.stringify({ code: response.status, ...result }))
    }
});

document.getElementById("signup").addEventListener("submit", async (e) => {
    e.preventDefault();

    const form = new FormData(e.target);
    const response = await fetch('http://localhost/residencial/?action=signup', {
        headers: { 'Content-Type': 'application/json' },
        method: 'POST',
        body: JSON.stringify({
            username: form.get("username"),
            email: form.get("email"),
            pass: form.get("pass")
        })
    })

    const result = await response.json();

    if (response.status === 201) {
        alert(result.message)
    } else {
        alert(JSON.stringify({ code: response.status, ...result }))
    }

})
