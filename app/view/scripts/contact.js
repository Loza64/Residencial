document.getElementById("contact").addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    const formatDateToYYYYMMDD = (dateString) => {  
        const date = new Date(dateString);  
        const year = date.getFullYear();  
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0'); 
        return `${year}-${month}-${day}`;  
    };

    const contact = {  
        iduser: formData.get('iduser'),  
        name: formData.get('name'),  
        birth: formatDateToYYYYMMDD(formData.get('birth')),
        dui: formData.get('dui'),  
        email: formData.get('email'),  
        phone: formData.get('phone'),  
        address: formData.get('address'),  
        occupation: formData.get('occupation'),  
        income: parseFloat(formData.get('income')),  
        family_members: parseInt(formData.get('family_members')),  
        reason_interest: formData.get('reason_interest'),  
        personal_reference: formData.get('personal_reference'),  
        application_date: formatDateToYYYYMMDD(formData.get('application_date'))
    };

    const response = await fetch('http://localhost/residencial/?action=contact', {
        method:'POST',
        headers:{'Content-Type': 'application/json'},
        body:JSON.stringify(contact)
    })

    const result = await response.json();

    if(response.status === 201){
        alert(result.message)
    }else{
        alert(JSON.stringify({ code: response.status, ...result }))
    }
    
})