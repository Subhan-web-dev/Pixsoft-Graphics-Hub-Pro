const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});





// Dummy users data (Replace with actual backend validation)
// const users = [
//     { username: 'admin123@gmail.com', password: 'admin123', role: 'admin' },
//     { username: 'user123@gmail.com', password: 'user123', role: 'customer' }
// ];

// function validateLogin(event) {
//     event.preventDefault(); 

//     const username = document.getElementById('username').value.trim();
//     const password = document.getElementById('password').value.trim();
//     const role = document.getElementById('role').value;

//     if (!username || !password) {
//         alert('Please enter both username and password');
//         return;
//     }

    // Find user with matching credentials
    // const user = users.find(u => u.username === username && u.password === password && u.role === role);

    // if (user) {
    //     alert(`Login successful as ${role}`);
        
        // Save session data
//         sessionStorage.setItem('loggedInUser', JSON.stringify(user));

        
//         setTimeout(() => {
//             if (role === 'admin') {
//                 window.location.href = 'Admin-Dashboard.html';
//             } else {
//                 window.location.href = 'Customer-Dashboard.html';
//             }
//         }, 300);
//     } else {
//         alert('Invalid username, password, or role selection');
//     }
// }



document.getElementById('loginForm').addEventListener('submit', validateLogin);



