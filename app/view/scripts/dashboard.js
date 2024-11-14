function showSection(sectionId) {

    document.getElementById('user-section').style.display = sectionId === 'user-section' ? 'block' : 'none';
    document.getElementById('request-section').style.display = sectionId === 'request-section' ? 'block' : 'none';


    document.querySelector('.navigation a[onclick*="user-section"]').classList.toggle('active', sectionId === 'user-section');
    document.querySelector('.navigation a[onclick*="request-section"]').classList.toggle('active', sectionId === 'request-section');
}


document.getElementById('userSearch').addEventListener('keyup', (e) => {
    if (e.key === 'Enter') {
        const search = e.target.value;
        fetchUsers(search);
    }
})

async function deleteUser(userId) {
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        const response = await fetch(`http://localhost/residencial/?action=deleteduser&id=${userId}`, { method: 'DELETE' })
        const result = await response.json();
        if (response.status === 200) {
            alert(result.message);
            fetchUsers(searchTerm = '')
        } else {
            alert(`error ${response.status}: ${response.message}`);
        }
    }
}

async function fetchUsers(searchTerm = '') {
    const response = await fetch(`http://localhost/residencial/?action=users&search=${searchTerm}`);
    const result = await response.json();
    if (response.status === 200) {
        const users = result.users;
        const userSection = document.querySelector('.user-list');
        userSection.innerHTML = '';

        users.forEach(user => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `
            <span>Estado: ${user.state}</span>
            <span>Username: ${user.username}</span>
            <span>Rol: ${user.rol}</span>
            <button onclick="deleteUser(${user.id})">Eliminar</button>
            `;
            userSection.appendChild(listItem);
        });
    } else if (response.status === 401) {
        alert(result.message)
    } else if (response.status === 404) {
        if (searchTerm === '') {
            alert(result.message)
        } else {
            alert(result.message)
            fetchUsers();
        }
    } else if (response.status === 400) {
        alert(result.message)
    } else {
        alert(`Error ${response.status}: ${result.message}`)
    }
}

function openCardDetails(contact) {
    const { id, user, name, dui, email, phone, address, occupation, income, family_members, reason_interest, personal_reference, application_date } = contact;

    const width = 400;
    const height = 650;

    const left = (window.innerWidth / 2) - (width / 2);
    const top = (window.innerHeight / 2) - (height / 2);

    const detailsWindow = window.open("", "_blank", `width=${width},height=${height},top=${top},left=${left}`);
    detailsWindow.document.write(`  
        <html>  
            <head>  
                <title>Detalles de la Solicitud</title>  
                <style>  
                    body { font-family: 'Poppins', sans-serif;   
                            padding: 20px;   
                            line-height: 1.6;   
                            background-color: #2c3e50;   
                            color: #FFFFFF;  
                        }  
                    h2 { color: #FFFFFF; }  
                    p { margin: 10px 0; }  
                    button { margin-top: 10px; padding: 10px; font-size: 16px; cursor: pointer; }
                    .accept-btn { background-color: #4CAF50; color: white; }
                    .deny-btn { background-color: #f44336; color: white; }
                </style>  
            </head>  
            <body>  
                <h2>Detalles de la Solicitud</h2>  
                <p><strong>Usuario:</strong> ${user}</p>  
                <p><strong>Nombre:</strong> ${name}</p>  
                <p><strong>DUI:</strong> ${dui}</p>  
                <p><strong>Email:</strong> ${email}</p>  
                <p><strong>Teléfono:</strong> ${phone}</p>  
                <p><strong>Dirección:</strong> ${address}</p>  
                <p><strong>Ocupación:</strong> ${occupation}</p>  
                <p><strong>Ingreso Mensual:</strong> $${income}</p>  
                <p><strong>Miembros del Hogar:</strong> ${family_members}</p>  
                <p><strong>Motivo de Interés:</strong> ${reason_interest}</p>  
                <p><strong>Referencias:</strong> ${personal_reference}</p>  
                <p><strong>Fecha de Aplicación:</strong> ${application_date}</p>  

                <button class="accept-btn" onclick="window.opener.updateUserStatus(${id}, 'approved', ${contact.id})">ACEPTAR</button>  
                <button class="deny-btn" onclick="window.opener.updateUserStatus(${id}, 'denied', ${contact.id})">DENEGAR</button>  
            </body>  
        </html>  
    `);
    detailsWindow.document.close();
}

async function updateUserStatus(userId, status, contactId) {
    const response = await fetch(`http://localhost/residencial/?action=updateStatus&id=${userId}&status=${status}`, {
        method: 'POST'
    });
    const result = await response.json();

    if (response.status === 200) {
        alert(result.message);

        const card = document.querySelector(`.card[data-id="${contactId}"]`);
        if (status === 'approved') {
            card.style.backgroundColor = '#4CAF50'; // Verde para aprobado
        } else if (status === 'denied') {
            card.style.backgroundColor = '#f44336'; // Rojo para denegado
        }
    } else {
        alert(`Error ${response.status}: ${result.message}`);
    }
}

//Al presionar Enter, buscar formulario de contacto
document.getElementById('contactSearch').addEventListener('keyup', (e) => {
    if (e.key === 'Enter') {
        const search = e.target.value;
        fetchContacts(search);
    }
});

async function fetchContacts(searchTerm = '') {
    const card_container = document.querySelector(".card-container");
    card_container.innerHTML = ''; // Limpiar buscador 

    const response = await fetch(`http://localhost/residencial/?action=contacts&search=${searchTerm}`);
    const result = await response.json();

    if (response.status === 200) {
        const contacts = result.contacts;

        contacts.forEach((item) => {
            const div = document.createElement('div');
            div.className = "card";
            div.dataset.id = item.id;

            div.onclick = () => openCardDetails(item);

            div.innerHTML = `  
                <p><strong>Nombre:</strong> ${item.name}</p>  
                <p><strong>DUI:</strong> ${item.dui}</p>  
                <p><strong>Teléfono:</strong> ${item.phone}</p>  
                <p><strong>Dirección:</strong> ${item.address}</p>  
            `;
            card_container.appendChild(div);
        });
    } else if (response.status === 401) {
        alert(result.message);
    } else {
        alert(`Error ${response.status}: ${result.message}`);
    }
}

function filterContacts() {
    const searchTerm = document.getElementById('contactSearch').value;
    fetchContacts(searchTerm);
}

window.onload = function () {
    fetchUsers();
    fetchContacts();
}

