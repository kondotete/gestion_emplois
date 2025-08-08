document.getElementById('seanceForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://localhost/emploi-du-temps/php/ajouter_emploi.php', {
    method: 'POST',
    body: formData
    })
    .then(res => res.json())
    .then(data => {
    const message = document.getElementById('message');
    if (data.success) {
        message.innerHTML = `<p class="text-green-600">✅ Séance ajoutée</p>`;
        this.reset();
    } else {
        message.innerHTML = `<p class="text-red-600">❌ ${data.error}</p>`;
    }
    })
    .catch(err => {
    document.getElementById('message').innerHTML = `<p class="text-red-600">Erreur réseau</p>`;
    console.error(err);
    });
});
