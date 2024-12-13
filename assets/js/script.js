const buttons = document.querySelectorAll('.tab-button');
const contents = document.querySelectorAll('.tab-content');

buttons.forEach(button => {
    button.addEventListener('click', () => {
        const target = button.getAttribute('data-tab');

        // Retirer les classes "active"
        buttons.forEach(btn => btn.classList.remove('active-tab'));
        contents.forEach(content => content.classList.remove('active'));

        // Activer l'onglet et le contenu correspondant
        button.classList.add('active-tab');
        document.getElementById(target).classList.add('active');
    });
});
