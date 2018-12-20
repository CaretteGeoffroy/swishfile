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

            let dataUpload = res.dataUpload;
            let dataDownload = res.dataDownload;

            let arrayUpload =  [0,0,0,0,0,0,0];
            let arrayDownload =  [0,0,0,0,0,0,0];
            
            

            for (let i of dataUpload ) {
                console.log(i)
            }
        
            // Bar chart
            let uploadCharts = new Chart(document.getElementById("chartDownload"), {
                type: 'bar',
                data: {
                    labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
                    datasets: [{
                        label: "Upload by date",
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850", "#3cba9f", "#3e95cd"],
                        data: [2478, 5267, 734, 784, 433, 450, 100]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Download/Jours'
                    }
                }
            });

            let downloadCharts = new Chart(document.getElementById("chartUpload"), {
                type: 'bar',
                data: {
                    labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
                    datasets: [{
                        label: "Upload by date",
                        backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850", "#3cba9f", "#3e95cd"],
                        data: [2478, 5267, 734, 784, 433, 450, 100]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Upload/Jours'
                    }
                }
            }); 


        })
        .catch((err) => {
            if (err) throw err;
        })
}