// import './bootstrap';
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('tagged_users_input');
    const list = document.getElementById('tagged_users_list');
    const hiddenInput = document.getElementById('tagged_users_hidden');

    input.addEventListener('input', function () {
        const query = input.value;

        if (query.length >= 2) { // Mulai pencarian jika panjang input >= 2 karakter
            fetch(`/search?q=${query}`)
                .then(response => response.json())
                .then(users => {
                    list.innerHTML = ''; // Kosongkan daftar sebelumnya

                    users.forEach(user => {
                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item list-group-item-action';
                        listItem.textContent = user.mt_username;
                        listItem.dataset.id = user.id;

                        listItem.addEventListener('click', function () {
                            // Tambahkan ID pengguna ke hidden input
                            let selectedUsers = hiddenInput.value
                                ? hiddenInput.value.split(',')
                                : [];
                            if (!selectedUsers.includes(user.id.toString())) {
                                selectedUsers.push(user.id);
                                hiddenInput.value = selectedUsers.join(',');
                            }

                            // Tambahkan nama pengguna ke input
                            input.value = selectedUsers.map(id => users.find(u => u.id == id).mt_username).join(', ');

                            // Kosongkan daftar pencarian
                            list.innerHTML = '';
                        });

                        list.appendChild(listItem);
                    });
                });
        } else {
            list.innerHTML = ''; // Kosongkan daftar jika input terlalu pendek
        }
    });
});

