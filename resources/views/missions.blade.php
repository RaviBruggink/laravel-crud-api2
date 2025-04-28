<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Space Missions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-8 text-center">🚀 Interstellar Missions</h1>

        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">All Missions</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="py-3 px-6 text-left">Mission Name</th>
                            <th class="py-3 px-6 text-left">Launch Date</th>
                            <th class="py-3 px-6 text-left">Destination</th>
                            <th class="py-3 px-6 text-left">Crew Size</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="missions" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Missions will be inserted here -->
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-semibold mb-4">Add a New Mission</h2>
            <form id="missionForm" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow space-y-4">
                <div>
                    <input type="text" id="name" placeholder="Mission Name" required class="w-full p-2 rounded border dark:border-gray-600 bg-gray-100 dark:bg-gray-700">
                </div>
                <div>
                    <input type="date" id="launch_date" required class="w-full p-2 rounded border dark:border-gray-600 bg-gray-100 dark:bg-gray-700">
                </div>
                <div>
                    <input type="text" id="destination" placeholder="Destination" required class="w-full p-2 rounded border dark:border-gray-600 bg-gray-100 dark:bg-gray-700">
                </div>
                <div>
                    <input type="number" id="crew_size" placeholder="Crew Size" required class="w-full p-2 rounded border dark:border-gray-600 bg-gray-100 dark:bg-gray-700">
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Add Mission
                    </button>
                </div>
            </form>
        </section>
    </div>

    <script>
        const API_URL = "http://localhost/api/missions";
        const API_KEY = "password123";

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
                    <td class="py-3 px-6">${mission.name}</td>
                    <td class="py-3 px-6">${mission.launch_date}</td>
                    <td class="py-3 px-6">${mission.destination}</td>
                    <td class="py-3 px-6">${mission.crew_size}</td>
                    <td class="py-3 px-6 space-x-2">
                        <button onclick="editMission(${mission.id})" class="text-yellow-500 hover:text-yellow-700">✏️ Edit</button>
                        <button onclick="deleteMission(${mission.id})" class="text-red-500 hover:text-red-700">🗑️ Delete</button>
                    </td>
                `;
                missionsTbody.appendChild(row);
            });
        }

        document.getElementById('missionForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const missionData = {
                name: document.getElementById('name').value,
                launch_date: document.getElementById('launch_date').value,
                destination: document.getElementById('destination').value,
                crew_size: document.getElementById('crew_size').value
            };

            await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-API-KEY': API_KEY
                },
                body: JSON.stringify(missionData)
            });

            document.getElementById('missionForm').reset();
            fetchMissions();
        });

        async function deleteMission(id) {
            await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-API-KEY': API_KEY
                }
            });
            fetchMissions();
        }

        async function editMission(id) {
            const newName = prompt("Enter new mission name:");
            if (!newName) return;

            await fetch(`${API_URL}/${id}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-API-KEY': API_KEY
                },
                body: JSON.stringify({ name: newName })
            });

            fetchMissions();
        }

        fetchMissions();
    </script>
</body>
</html>