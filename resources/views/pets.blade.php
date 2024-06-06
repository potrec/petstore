<!DOCTYPE html>
<html>
<head>
    <title>Petstore</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Petstore</h1>
    <form id="petForm">
        @csrf
        <input type="hidden" id="petId" name="id">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" class="form-control" id="status" name="status">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="petsList"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const petForm = document.getElementById('petForm');

        petForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(petForm);
            const id = formData.get('id');
            const url = id ? `/pets/${id}` : '/pets';
            const method = id ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
                .then(response => response.json())
                .then(data => {
                    petForm.reset();
                    fetchPets();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`Error: ${error.message}`);
                });
        });

        function fetchPets() {
            fetch('/pets')
                .then(response => response.json())
                .then(pets => {
                    let petsList = '';
                    pets.forEach(pet => {
                        petsList += `<div>${pet.name} (${pet.status}) -
                        <button onclick="editPet(${pet.id})">Edit</button>
                        <button onclick="deletePet(${pet.id})">Delete</button></div>`;
                    });
                    document.getElementById('petsList').innerHTML = petsList;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        window.editPet = function(id) {
            fetch(`/pets/${id}`)
                .then(response => response.json())
                .then(pet => {
                    document.getElementById('petId').value = pet.id;
                    document.getElementById('name').value = pet.name;
                    document.getElementById('status').value = pet.status;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`Error: ${error.message}`);
                });
        }

        window.deletePet = function(id) {
            fetch(`/pets/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
                .then(response => response.json())
                .then(data => {
                    fetchPets();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`Error: ${error.message}`);
                });
        }

        fetchPets();
    });
</script>
</body>
</html>
