let selectYear;
let allWeeks;
let lastWeekId;

window.onload = (e) => {

    selectYear = document.querySelector("#select-week");
    allWeeks = selectYear.children;
    lastWeekId = allWeeks[allWeeks.length - 1].value;

    // Au chargement, affiche la semaine en cours
    fetchWeekInfo(lastWeekId);

}

// Quand je change mon select ...
document.querySelector("#select-week").addEventListener('change', (event) => {

    // Prend la valeur de l'option selectionné et fetch là.
    fetchWeekInfo(selectYear.options[selectYear.selectedIndex].value);
})


function fetchWeekInfo(week) {
    fetch(`/transfer-system/dashboard/week/${week}`)
        .then((res) => {
            return res.json()
        })
        .then((res) => {

            let wrapper = document.querySelector("#wrapper-chart");

            wrapper.innerHTML = res.canvas;

            // Bar chart
            new Chart(document.getElementById("chart"), {
                type: 'bar',
                data: {
                    labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                    datasets: [{
                        label: "Population (millions)",
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                        data: [2478, 5267, 734, 784, 433]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Predicted world population (millions) in 2050'
                    }
                }
            });


        })
        .catch((err) => {
            if (err) throw err;
        })
}