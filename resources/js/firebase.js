// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAuth, signInWithPopup, OAuthProvider } from "firebase/auth";

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAqNC946ZIdkV-cuIhDaK-2qC-UBkEayF8",
  authDomain: "mapache-web.firebaseapp.com",
  projectId: "mapache-web",
  storageBucket: "mapache-web.firebasestorage.app",
  messagingSenderId: "38122602279",
  appId: "1:38122602279:web:5fa48add7baf307205f302",
  measurementId: "G-RTP1BB3TP7"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Microsoft provider
const provider = new OAuthProvider('microsoft.com');

// Function to handle Microsoft login
window.microsoftLogin = function() {
  signInWithPopup(auth, provider)
    .then((result) => {
      // This gives you a Microsoft Access Token. You can use it to access the Microsoft API.
      const credential = OAuthProvider.credentialFromResult(result);
      const token = credential.accessToken;

      // The signed-in user info.
      const user = result.user;

      // Get the CSRF token from the meta tag
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Send the user info to your Laravel backend
      fetch('/firebase-login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
          uid: user.uid,
          email: user.email,
          name: user.displayName,
          token: token
        })
      }).then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.href = '/';
          } else {
            console.error('Login failed:', data.message);
          }
        }).catch(error => {
          console.error('Error parsing JSON:', error);
        });
    })
    .catch((error) => {
      // Handle Errors here.
      const errorCode = error.code;
      const errorMessage = error.message;
      console.error('Error during Microsoft login:', errorCode, errorMessage);
    });
}