document.getElementById('contact-form').addEventListener('submit', function(event) {
  event.preventDefault();

  var form = event.target;
  var formData = new FormData(form);
  
  fetch('process.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    var responseElement = document.getElementById('form-response');
    if (data.success) {
      responseElement.innerHTML = 'Thank you for your message!';
      responseElement.style.color = 'green';
      form.reset();
    } else {
      responseElement.innerHTML = data.message || 'There was an error submitting your message. Please try again.';
      responseElement.style.color = 'red';
    }
  })
  .catch(error => {
    var responseElement = document.getElementById('form-response');
    responseElement.innerHTML = 'There was an error submitting your message. Please try again.';
    responseElement.style.color = 'red';
  });
});
