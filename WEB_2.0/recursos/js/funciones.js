
function loadContent(url) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('content').innerHTML = xhr.responseText;
            attachFormSubmitEvents();
        } else {
            document.getElementById('content').innerHTML = '<p>Error al cargar el contenido.</p>';
        }
    };
    xhr.send();
}

function loadVoluntarios(id_evento) {
    loadContent('voluntarios_evento.php?id_evento=' + id_evento);
}

function addVoluntarios(id_evento) {
    loadContent('add_voluntario_evento.php?id_evento=' + id_evento);
}

function loadBeneficiarios(id_evento) {
    loadContent('beneficiarios_evento.php?id_evento=' + id_evento);
}

function addBeneficiarios(id_evento) {
    loadContent('add_beneficiario_evento.php?id_evento=' + id_evento);
}

function confirmDelete(url) {
    if (confirm('¿Estás seguro de que deseas eliminar este ítem?')) {
        loadContent(url);
    }
}

function attachFormSubmitEvents() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const action = this.getAttribute('action');
            const xhr = new XMLHttpRequest();
            xhr.open('POST', action, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('content').innerHTML = xhr.responseText;
                    attachFormSubmitEvents();
                } else {
                    document.getElementById('content').innerHTML = '<p>Error al cargar el contenido.</p>';
                }
            };
            xhr.send(formData);
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    attachFormSubmitEvents();
});
