function enableEditing() {
    const inputs = document.querySelectorAll('form#perfil input');
    inputs.forEach(input => input.removeAttribute('readonly'));
    document.querySelector('#edit-buttons button[type="button"]').style.display = 'none';
    document.querySelector('#edit-buttons button[type="submit"]').style.display = 'inline-block';
}

document.getElementById("perfil").addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = new FormData(e.target);
    const response = await fetch('https://localhost/residencial/?action=updateprofile', {
        headers: { 'Content-Type': 'application/json' },
        method: 'PUT',
        body: JSON.stringify({
            username: form.get("username"),
            email: form.get("email")
        })
});
    const result = await response.json();
    if (response.status === 200) {
        alert(result.message);
    } else if (response.status === 400) {
        alert(`Error ${response.status}: ${JSON.stringify(result.message)}`)
    }
    else {
        alert(`Error ${response.status}: ${result.message}`)
    }
});