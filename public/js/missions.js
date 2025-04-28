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
    const missionsBody = document.getElementById('missionsBody');
    missionsBody.innerHTML = "";

    missions.forEach(mission => {
        const row = document.createElement('tr');
        row.classList.add('border-b');

        row.innerHTML = `
            <td class="py-2 px-4">${mission.name}</td>
            <td class="py-2 px-4">${mission.launch_date}</td>
            <td class="py-2 px-4">${mission.destination}</td>
            <td class="py-2 px-4">${mission.crew_size}</td>
            <td class="py-2 px-4 space-x-2">
                <button onclick="editMission(${mission.id})" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">✏️ Edit</button>
                <button onclick="deleteMission(${mission.id})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">🗑️ Delete</button>
            </td>
        `;
        missionsBody.appendChild(row);
    });
}

document.addEventListener('DOMContentLoaded', fetchMissions);

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
    const newName = prompt("Enter the new mission name:");
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