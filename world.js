document.addEventListener('DOMContentLoaded', function() {
    const lookupButton = document.getElementById('lookup');
    lookupButton.addEventListener('click', function() {
        const country = document.getElementById('country').value;
        console.log(country);
        fetch('world.php?country='+ encodeURIComponent(country))
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });
});
