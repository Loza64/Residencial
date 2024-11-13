function showSection(sectionId) {

    document.getElementById('user-section').style.display = sectionId === 'user-section' ? 'block' : 'none';
    document.getElementById('request-section').style.display = sectionId === 'request-section' ? 'block' : 'none';


    document.querySelector('.navigation a[onclick*="user-section"]').classList.toggle('active', sectionId === 'user-section');
    document.querySelector('.navigation a[onclick*="request-section"]').classList.toggle('active', sectionId === 'request-section');
}

function deleteUser(userId) {
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        alert("Usuario con ID " + userId + " eliminado.");
        // Acá iría el AJAX para eliminar de la base de datos
    }
}

document.getElementById('userSearch').addEventListener('keyup', (e) => {
    if (e.key === 'Enter') {
        const search = e.target.value;
        fetchUsers(search);
    }
})

// Función para obtener usuarios desde la URL usando AJAX
async function fetchUsers(searchTerm = '') {
    const response = await fetch(`http://localhost/residencial/?action=getusers&search=${searchTerm}`);
    const result = await response.json();
    if (response.status === 200) {
        const users = result.users;
        const userSection = document.querySelector('.user-list');
        userSection.innerHTML = '';

        users.forEach(user => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                    <span>Username: ${user.username} | Rol: ${user.rol}</span>
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
        alert(result.message.parameter)
    } else {
        alert(`Error ${response.status}: ${result.message}`)
    }
}

function openCardDetails(username, name, dui, email, phone, address, occupation, income, familyMembers, interest, reference, applicationDate) {
    const detailsWindow = window.open("", "_blank", "width=400,height=600");
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
                </style>
            </head>
            <body>
                <h2>Detalles de la Solicitud</h2>
                <p><strong>usuario:</strong> ${username}</p>
                <p><strong>Nombre:</strong> ${name}</p>
                <p><strong>DUI:</strong> ${dui}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Teléfono:</strong> ${phone}</p>
                <p><strong>Dirección:</strong> ${address}</p>
                <p><strong>Ocupación:</strong> ${occupation}</p>
                <p><strong>Ingreso Mensual:</strong> $${income}</p>
                <p><strong>Miembros del Hogar:</strong> ${familyMembers}</p>
                <p><strong>Motivo de Interés:</strong> ${interest}</p>
                <p><strong>Referencias:</strong> ${reference}</p>
                <p><strong>Fecha de Aplicación:</strong> ${applicationDate}</p>
            </body>
        </html>
    `);
    detailsWindow.document.close();
}

async function fetchContacts() {  
    const card_container = document.querySelector(".card-container");  
    const response = await fetch('http://localhost/residencial/?action=listcontacts');  
    const result = await response.json();  

    if (response.status === 200) {  
        const contacts = result.contacts;  

        contacts.forEach((item) => {  
            const div = document.createElement('div');  
            div.className = "card";  
            div.dataset.id = item.id;  
            
            div.onclick = () => openCardDetails( 
                item.user, 
                item.name,  
                item.dui,  
                item.email,  
                item.phone,  
                item.address,  
                item.occupation,  
                item.income,  
                item.family_members,  
                item.reason_interest,  
                item.personal_reference,  
                item.application_date  
            );  
            
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

window.onload = function () {
    fetchUsers();
    fetchContacts();
}

