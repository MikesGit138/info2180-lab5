document.addEventListener('DOMContentLoaded', function() {
    const lookupButton = document.getElementById('lookup');
    const lookupCitiesButton = document.getElementById('lookup-cities');
    const resultDiv = document.getElementById('result');

    lookupButton.addEventListener('click', function() {
        performLookup(false);
    });

    lookupCitiesButton.addEventListener('click', function() {
        performLookup(true);
    });

    function performLookup(isCityLookup) {
        const country = document.getElementById('country').value;
        console.log(country)
        let url = 'world.php?country=' + encodeURIComponent(country);
        if (isCityLookup) {
            url += '&lookup=cities';
        }

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
});
