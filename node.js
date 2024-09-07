const axios = require('axios');

async function verifyRecaptcha(token) {
    const secretKey = '6LdPGzkqAAAAAMUfZ7Wqj9iwD7PFLL8P4ity0y7P';  // Your reCAPTCHA secret key
    const url = 'https://www.google.com/recaptcha/api/siteverify';
    
    try {
        const response = await axios.post(url, null, {
            params: {
                secret: secretKey,
                response: token
            }
        });
        return response.data;
    } catch (error) {
        console.error('Error verifying reCAPTCHA:', error);
    }
}
