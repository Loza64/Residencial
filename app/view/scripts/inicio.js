const domain = "192.168.1.4";

document.getElementById('logout').addEventListener('click', () => {
    window.location.href = `https://${domain}/residencial/?action=logout`
})