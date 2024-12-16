<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Samenstellen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h1 class="mb-4">Training Samenstellen</h1>

        <!-- Formulier voor training samenstellen -->
        <form id="trainingForm" method="POST" action="/api/training">
            <div class="mb-3">
                <label for="trainingName" class="form-label">Naam van de training</label>
                <input type="text" class="form-control" id="trainingName" name="name" placeholder="Bijvoorbeeld: Basis Zwemtraining" required>
            </div>

            <div class="mb-3">
                <label for="beschrijving" class="form-label">Beschrijving</label>
                <textarea class="form-control" id="beschrijving" name="beschrijving" rows="3" placeholder="Geef een korte beschrijving van de training"></textarea>
            </div>

            <!-- Dropdown met oefeningen, direct vanuit PHP -->
            <div class="mb-3">
                <label for="oefeningen" class="form-label">Kies oefeningen</label>
                <select class="form-select" id="oefeningenSelect" aria-label="Oefening selecteren">
                    <option value="" disabled selected>Selecteer een oefening</option>
                    <?php foreach ($oefeningen as $oefening): ?>
                        <option value="<?= htmlspecialchars($oefening->id) ?>">
                            <?= htmlspecialchars($oefening->name) ?> (<?= htmlspecialchars($oefening->duur) ?> min)
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="btn btn-secondary mt-2" id="addOefeningBtn">Voeg oefening toe</button>
            </div>

            <div class="mb-3">
                <h5>Geselecteerde oefeningen:</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Duur (min)</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody id="selectedOefeningenTable"></tbody>
                </table>
            </div>

            <div class="mb-3">
                <label for="totaleDuur" class="form-label">Totale duur</label>
                <input type="number" class="form-control" id="totaleDuur" name="totale_duur" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Training opslaan</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const oefeningenSelect = document.getElementById('oefeningenSelect');
            const addOefeningBtn = document.getElementById('addOefeningBtn');
            const selectedOefeningenTable = document.getElementById('selectedOefeningenTable');
            const totaleDuurInput = document.getElementById('totaleDuur');
            const trainingForm = document.getElementById('trainingForm');

            let geselecteerdeOefeningen = [];
            let totaleDuur = 0;

            // Voeg oefening toe aan de lijst
            addOefeningBtn.addEventListener('click', () => {
                const selectedOption = oefeningenSelect.options[oefeningenSelect.selectedIndex];
                if (selectedOption.value) {
                    const oefeningId = selectedOption.value;
                    const oefeningName = selectedOption.text.split('(')[0].trim();
                    const oefeningDuur = parseInt(selectedOption.text.match(/\d+/)[0]);

                    if (!geselecteerdeOefeningen.some(oef => oef.id === oefeningId)) {
                        geselecteerdeOefeningen.push({ id: oefeningId, name: oefeningName, duur: oefeningDuur });
                        totaleDuur += oefeningDuur;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${oefeningName}</td>
                            <td>${oefeningDuur}</td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-btn" data-id="${oefeningId}">Verwijder</button></td>
                        `;
                        selectedOefeningenTable.appendChild(row);

                        totaleDuurInput.value = totaleDuur;

                        row.querySelector('.remove-btn').addEventListener('click', (e) => {
                            const oefId = e.target.dataset.id;
                            const oefening = geselecteerdeOefeningen.find(o => o.id === oefId);
                            geselecteerdeOefeningen = geselecteerdeOefeningen.filter(o => o.id !== oefId);
                            totaleDuur -= oefening.duur;
                            totaleDuurInput.value = totaleDuur;
                            row.remove();
                        });
                    }
                }
            });

            // Formulierverzending
            trainingForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const data = {
                    name: trainingForm.name.value,
                    beschrijving: trainingForm.beschrijving.value,
                    totale_duur: totaleDuur,
                    oefeningen: geselecteerdeOefeningen.map(oef => oef.id), // Verzamel alleen de IDs van oefeningen
                };

                fetch('/api/training', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(result => {
                    if (result.message) {
                        alert('Training opgeslagen!');
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Er is een fout opgetreden.');
                });
            });
        });
    </script>
</body>
</html>
