const domain = `${window.location.hostname}:${window.location.port}`;

document.getElementById('logout').addEventListener('click', () => {
    window.location.href = `https://${domain}/?action=logout`
})