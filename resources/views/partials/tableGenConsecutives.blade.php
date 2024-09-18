{{-- TABLA --}}
<div class="relative overflow-x-auto mt-6 rounded-lg">
    <table id="resultsTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Fecha
                </th>
                <th scope="col" class="px-6 py-3">
                    Nuevo consecutivo
                </th>
                <th scope="col" class="px-6 py-3">
                    Acción
                </th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<script>
    //Manejo del envio del formulario de sumar
    document.getElementById('dataForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const date = new Date(document.getElementById('dateAdd').value);
        const consecutive = parseInt(document.getElementById('consecutiveAdd').value, 10);

        if (isNaN(consecutive) || !date) {
            alert("Por favor, ingrese un consecutivo válido y una fecha.");
            return;
        }

        const data = [];
        const length = consecutive.toString().length;

        for (let i = 0; i < 15; i++) {
            const newDate = new Date(date);
            newDate.setDate(date.getDate() + i);
            const newConsecutive = (consecutive + 845 * i).toString().padStart(length, '0');
            data.push({
                date: newDate.toISOString().split('T')[0],
                consecutive: newConsecutive
            });
        }
        console.log(data);

        const tbody = document.getElementById('resultsTable').querySelector('tbody');
        tbody.innerHTML = data.map(item => `
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${item.date}</td>
                <td class="px-6 py-4">${item.consecutive}</td>
                <td class="px-6 py-4">
                    <button class="fill-form text-gray-900 bg-violet-400 hover:bg-violet-500 focus:ring-4 focus:bg-violet-600 rounded-lg text-sm px-4 py-2 focus:outline-none"
                        onclick="fillForm('${item.date}', '${item.consecutive}')">
                        <x-svg-icon name="icon-copy" class="w-4 h-4 text-black" aria-hidden="true" />
                    </button>
                    <button class="text-gray-900 bg-violet-400 hover:bg-violet-500 focus:ring-4 focus:bg-violet-600 rounded-lg text-sm px-4 py-2 focus:outline-none"
                        onclick="openModal('${item.date}', '${item.consecutive}')">
                        <x-svg-icon name="icon-save" class="w-4 h-4 text-black" aria-hidden="true" />
                    </button>
                </td>
            </tr>
        `).join('');
    });

    //manejo de modal
    function openModal(date, consecutive) {
        document.getElementById('myModal').classList.remove('hidden');
        document.getElementById('id-save-consecutive').value = consecutive;
        document.getElementById('id-save-date').value = date;
    }

    function closeModal() {
        document.getElementById('myModal').classList.add('hidden');
    }

    //llenar campos del formulario de descarga de peajes
    function fillForm(date, consecutive) {
        document.getElementById('date').value = date;
        document.getElementById('consecutive').value = consecutive;
    }
</script>
