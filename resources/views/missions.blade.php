<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Space Missions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-gray-200 min-h-screen">

    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-10 text-center text-green-400">Interstellar Missions</h1>

        <div class="flex justify-end mb-6">
            <button onclick="openCreateModal()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">
                + New Mission
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-900 rounded-lg shadow-lg">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="py-3 px-6 text-left">Mission Name</th>
                        <th class="py-3 px-6 text-left">Launch Date</th>
                        <th class="py-3 px-6 text-left">Destination</th>
                        <th class="py-3 px-6 text-left">Crew Size</th>
                        <th class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="missions" class="divide-y divide-gray-700">
                    <!-- Missions will appear here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
        <div class="bg-gray-800 p-8 rounded-xl w-full max-w-md">
            <h2 id="modalTitle" class="text-2xl font-bold mb-6 text-center">New Mission</h2>
            <form id="modalForm" class="space-y-4">
                <input type="hidden" id="missionId">
                <input type="text" id="name" placeholder="Mission Name" required class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                <input type="date" id="launch_date" required class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                <input type="text" id="destination" placeholder="Destination" required class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                <input type="number" id="crew_size" placeholder="Crew Size" required class="w-full p-3 rounded bg-gray-700 border border-gray-600 text-white">
                <div class="flex space-x-4 pt-4">
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold">
                        Save
                    </button>
                    <button type="button" onclick="closeModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 rounded-lg font-semibold">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
        <div class="bg-gray-800 p-8 rounded-xl w-full max-w-md text-center">
            <h2 class="text-2xl font-bold mb-6 text-red-400">Confirm Deletion</h2>
            <p class="text-gray-300 mb-6">Are you sure you want to delete this mission?</p>
            <div class="flex space-x-4">
                <button id="confirmDeleteBtn" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-semibold">
                    Delete
                </button>
                <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 rounded-lg font-semibold">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        const API_URL = "http://localhost/api/missions";
        const API_KEY = "password123";

        let deleteMissionId = null;

        async function fetchMissions() {
            const response = await fetch(API_URL, {
                headers: {
                    'Accept': 'application/json',
                    'X-API-KEY': API_KEY
                }
            });
            const missions = await response.json();
            displayMissions(missions);
        }

        function displayMissions(missions) {
            const missionsTbody = document.getElementById('missions');
            missionsTbody.innerHTML = "";

            missions.forEach(mission => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="py-4 px-6">${mission.name}</td>
                    <td class="py-4 px-6">${mission.launch_date}</td>
                    <td class="py-4 px-6">${mission.destination}</td>
                    <td class="py-4 px-6">${mission.crew_size}</td>
                    <td class="py-4 px-6 space-x-2">
                        <button onclick="openEditModal(${mission.id})" class="text-yellow-400 hover:text-yellow-500">Edit</button>
                        <button onclick="openDeleteModal(${mission.id})" class="text-red-400 hover:text-red-500">Delete</button>
                    </td>
                `;
                missionsTbody.appendChild(row);
            });
        }

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = "New Mission";
            document.getElementById('modalForm').reset();
            document.getElementById('missionId').value = "";
            document.getElementById('modal').classList.remove('hidden');
        }

        function openEditModal(id) {
            fetch(`${API_URL}/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-API-KEY': API_KEY
                }
            })
            .then(res => res.json())
            .then(mission => {
                document.getElementById('modalTitle').textContent = "Edit Mission";
                document.getElementById('missionId').value = mission.id;
                document.getElementById('name').value = mission.name;
                document.getElementById('launch_date').value = mission.launch_date;
                document.getElementById('destination').value = mission.destination;
                document.getElementById('crew_size').value = mission.crew_size;
                document.getElementById('modal').classList.remove('hidden');
            });
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        document.getElementById('modalForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('missionId').value;
            const missionData = {
                name: document.getElementById('name').value,
                launch_date: document.getElementById('launch_date').value,
                destination: document.getElementById('destination').value,
                crew_size: document.getElementById('crew_size').value
            };

            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/${id}` : API_URL;

            await fetch(url, {
                method,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-API-KEY': API_KEY
                },
                body: JSON.stringify(missionData)
            });

            closeModal();
            fetchMissions();
        });

        function openDeleteModal(id) {
            deleteMissionId = id;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
            await fetch(`${API_URL}/${deleteMissionId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-API-KEY': API_KEY
                }
            });
            closeDeleteModal();
            fetchMissions();
        });

        fetchMissions();
    </script>

</body>
</html>
