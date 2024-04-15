function updateLiveTime() {
    const liveTimeElement = document.getElementById("liveTime");
    setInterval(() => {
        liveTimeElement.textContent = getCurrentTime();
    }, 1000);
}

function fetchStudentData(rollNumber) {
    fetch('fetch_student_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `rollNumber=${rollNumber}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            displayStudentData(data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayStudentData(data) {
    const userDetails = document.querySelector('.user-details h3');
    const userDepartment = document.querySelector('#userDepartment');
    const userSchool = document.querySelector('#userSchool');
    const userImage = document.querySelector('.user-details img');
    const timeOfScan = document.querySelector('#userScan');

    userDetails.innerHTML = `Welcome,<br>${data.name}`;
    userDepartment.textContent = `Department: ${data.department}`;
    userSchool.textContent = `School: ${data.school}`;
    timeOfScan.textContent = `Time of Scan: ${getCurrentTime()}`;
    userImage.src = data.imageSrc;
}

function getCurrentTime() {
    const now = new Date();
    const hours = now.getHours() % 12 || 12;
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const amPm = now.getHours() < 12 ? 'AM' : 'PM';

    return `${hours}:${minutes}:${seconds} ${amPm}`;
}

document.querySelector('.middle-panel form').addEventListener('submit', function (event) {
    event.preventDefault();
    const rollNumber = document.getElementById('idInput').value;
    fetchStudentData(rollNumber);
});

updateLiveTime();
