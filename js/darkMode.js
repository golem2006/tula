document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('darkBtn');
    const body = document.body;
    if (localStorage.getItem('dark') == '1') {
        body.classList.add('dark');
    } else {
        if (body.classList.contains('dark')) {
            body.classList.remove('dark');
        }
    }

    btn.addEventListener('click', () => {
        body.classList.toggle('dark');
        if(body.classList.contains('dark')) {
            localStorage.setItem('dark', 1);
        } else {
            localStorage.setItem('dark', 0);
        }
    });
});