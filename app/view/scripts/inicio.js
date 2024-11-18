const domain = window.location.hostname;

document.getElementById('logout').addEventListener('click', () => {
    window.location.href = `https://${domain}/residencial/?action=logout`
})